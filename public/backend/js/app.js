/*!
 * 
 * Singular - Bootstrap Admin Theme + AngularJS
 * 
 * Author: @geedmo
 * Website: http://geedmo.com
 * License: http://themeforest.net/licenses/standard?license=regular
 * 
 */

if (typeof $ === 'undefined') { throw new Error('This application\'s JavaScript requires jQuery'); }

var App = angular.module('singular', ['ngRoute', 'ngAnimate', 'ngStorage', 'ngCookies', 'ui.bootstrap', 'ui.router', 'oc.lazyLoad', 'cfp.loadingBar', 'ui.utils'] , function($interpolateProvider)
{
  $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

}).run(["$rootScope", "$state", "$stateParams", '$localStorage', function ($rootScope, $state, $stateParams, $localStorage) {
    // Set reference to access them from any scope

    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.$storage = $localStorage;

    // Scope Globals
    // ----------------------------------- 
    $rootScope.app = {
      name: 'Singular',
      description: 'Bootstrap + AngularJS',
      year: ((new Date()).getFullYear()),
      viewAnimation: 'ng-fadeInLeft2',
      layout: {
        isFixed: true,
        isBoxed: true,
        isRTL: false
      },
      sidebar: {
        isCollapsed: false,
        slide: false
      },
      themeId: 0,
      theme: {
        sidebar: 'bg-inverse',
        brand:   'bg-inverse',
        topbar:  'bg-white'
      }
    };

  }
]);

// Application Controller
// ----------------------------------- 

App.controller('AppController',
  ['$rootScope', '$scope', '$state', '$window', '$localStorage', '$timeout','toggleStateService', 'colors', 'browser', 'cfpLoadingBar', '$http', 'flotOptions', 'support',
  function($rootScope, $scope, $state, $window, $localStorage, $timeout, toggle, colors, browser, cfpLoadingBar, $http, flotOptions, support) {
    "use strict";

    if(support.touch)
      $('html').addClass('touch');

    // Loading bar transition
    // ----------------------------------- 
    
    var latency;
    $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
        if($('.app-container > section').length) // check if bar container exists
          latency = $timeout(function() {
            cfpLoadingBar.start();
          }, 0); // sets a latency Threshold
    });
    $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
        event.targetScope.$watch("$viewContentLoaded", function () {
          $timeout.cancel(latency);
          cfpLoadingBar.complete();
        });
    });

    // State Events Hooks
    // ----------------------------------- 

    // Hook not found
    $rootScope.$on('$stateNotFound',
      function(event, unfoundState, fromState, fromParams) {
          console.log(unfoundState.to); // "lazy.state"
          console.log(unfoundState.toParams); // {a:1, b:2}
          console.log(unfoundState.options); // {inherit:false} + default options
      });

    // Hook success
    $rootScope.$on('$stateChangeSuccess',
      function(event, toState, toParams, fromState, fromParams) {
        // display new view from top
        $window.scrollTo(0, 0);
      });

    // Create your own per page title here
    $rootScope.pageTitle = function() {
      return $rootScope.app.name + ' - ' + $rootScope.app.description;
    };

    // Restore layout settings
    // ----------------------------------- 

    if( angular.isDefined($localStorage.settings) )
      $rootScope.app = $localStorage.settings;
    else
      $localStorage.settings = $rootScope.app;

    $rootScope.$watch("app.layout", function () {
      $localStorage.settings = $rootScope.app;
    }, true);

    
    // Allows to use branding color with interpolation
    // {{ colorByName('primary') }}
    $scope.colorByName = colors.byName;

    // Restore application classes state
    toggle.restoreState( $(document.body) );

    $rootScope.cancel = function($event) {
      $event.stopPropagation();
    };


}]);

/**=========================================================
 * Module: config.js
 * App routes and resources configuration
 =========================================================*/

App.config(['$stateProvider','$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', '$ocLazyLoadProvider', 'appDependencies',
    function ($stateProvider, $urlRouterProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, $ocLazyLoadProvider, appDependencies) {
      'use strict';

      App.controller = $controllerProvider.register;
      App.directive  = $compileProvider.directive;
      App.filter     = $filterProvider.register;
      App.factory    = $provide.factory;
      App.service    = $provide.service;
      App.constant   = $provide.constant;
      App.value      = $provide.value;

      // LAZY LOAD MODULES
      // ----------------------------------- 

      $ocLazyLoadProvider.config({
        debug: false,
        events: true,
        modules: appDependencies.modules
      });

      // default route to dashboard
      $urlRouterProvider.otherwise('');

      // 
      // App Routes
      // -----------------------------------   
      $stateProvider
        .state('app', {
            url: '/app',
            abstract: true,
            controller: 'AppController'
        })
        .state('app.dashboard', {
            url: '/dashboard'
        });

        // Change here your views base path
        function basepath(uri) {
          return 'app/views/' + uri;
        }

        // Generates a resolve object by passing script names
        // previously configured in constant.appDependencies
        // Also accept functions that returns a promise
        function requireDeps() {
          var _args = arguments;
          return {
            deps: ['$ocLazyLoad','$q', function ($ocLL, $q) {
              // Creates a promise chain for each argument
              var promise = $q.when(1); // empty promise
              for(var i=0, len=_args.length; i < len; i ++){
                promise = addThen(_args[i]);
              }
              return promise;

              // creates promise to chain dynamically
              function addThen(_arg) {
                // also support a function that returns a promise
                if(typeof _arg == 'function')
                    return promise.then(_arg);
                else
                    return promise.then(function() {
                      // if is a module, pass the name. If not, pass the array
                      var whatToLoad = getRequired(_arg);
                      // simple error check
                      if(!whatToLoad) return $.error('Route resolve: Bad resource name [' + _arg + ']');
                      // finally, return a promise
                      return $ocLL.load( whatToLoad );
                    });
              }
              // check and returns required data
              // analyze module items with the form [name: '', files: []]
              // and also simple array of script files (for not angular js)
              function getRequired(name) {
                if (appDependencies.modules)
                    for(var m in appDependencies.modules)
                        if(appDependencies.modules[m].name && appDependencies.modules[m].name === name)
                            return appDependencies.modules[m];
                return appDependencies.scripts && appDependencies.scripts[name];
              }

            }]};
        }


}]).controller('NullController', function() {});


/**=========================================================
 * Module: constants.js
 * Define constants to inject across the application
 =========================================================*/

App.constant('appDependencies', {
    // jQuery based and standalone scripts
    scripts: {
      'animate':            ['app/vendor//animate.css/animate.min.css'],
      'slimscroll':         ['vendor/slimscroll/jquery.slimscroll.min.js'],
      'moment' :            ['app/vendor/moment/min/moment-with-locales.min.js'],
      'inputmask':          ['app/vendor/jquery.inputmask/dist/jquery.inputmask.bundle.min.js'],
      'flatdoc':            ['app/vendor/flatdoc/flatdoc.js']
    },
    // Angular based script (use the right module name)
    modules: [
      {name: 'angular-chosen',    files: ['app/vendor/chosen_v1.2.0/chosen.jquery.min.js',
                                          'app/vendor/chosen_v1.2.0/chosen.min.css',
                                          'app/vendor/angular-chosen/angular-chosen.js']},
      {name: 'ngTable',           files: ['app/vendor/ng-table/ng-table.min.js',
                                          'app/vendor/ng-table/ng-table.min.css']},
      {name: 'ngTableExport',     files: ['app/vendor/ng-table-export/ng-table-export.js']},
      {name: 'flow',              files: ['app/vendor/angular-flow/angular-flow.js']}
    ]

  })
  // Same colors as defined in the css
  .constant('appColors', {
    'primary':                '#43a8eb',
    'success':                '#88bf57',
    'info':                   '#8293b9',
    'warning':                '#fdaf40',
    'danger':                 '#eb615f',
    'inverse':                '#363C47',
    'turquoise':              '#2FC8A6',
    'pink':                   '#f963bc',
    'purple':                 '#c29eff',
    'orange':                 '#F57035',
    'gray-darker':            '#2b3d51',
    'gray-dark':              '#515d6e',
    'gray':                   '#A0AAB2',
    'gray-light':             '#e6e9ee',
    'gray-lighter':           '#f4f5f5'
  })
  // Same MQ as defined in the css
  .constant('appMediaquery', {
    'desktopLG':             1200,
    'desktop':                992,
    'tablet':                 768,
    'mobile':                 480
  });


/**=========================================================
 * Module: PortletsController.js
 * Controller for the Tasks APP
 =========================================================*/

App.controller("TasksController", TasksController);

function TasksController($scope, $filter, $modal) {
  'use strict';
  var vm = this;

  vm.taskEdition = false;

  vm.tasksList = [
    {
      task: {title: "Solve issue #5487", description: "Praesent ultrices purus eget velit aliquet dictum. "},
      complete: true
    },
    {
      task: {title: "Commit changes to branch future-dev.", description: ""},
      complete: false
    }
    ];


  vm.addTask = function(theTask) {

    if( theTask.title === "" ) return;
    if( !theTask.description ) theTask.description = "";

    if( vm.taskEdition ) {
      vm.taskEdition = false;
    }
    else {
      vm.tasksList.push({task: theTask, complete: false});
    }
  };

  vm.editTask = function(index, $event) {

    $event.stopPropagation();
    vm.modalOpen(vm.tasksList[index].task);
    vm.taskEdition = true;
  };

  vm.removeTask = function(index, $event) {
    vm.tasksList.splice(index, 1);
  };

  vm.clearAllTasks = function() {
    vm.tasksList = [];
  };

  vm.totalTasksCompleted = function() {
    return $filter("filter")(vm.tasksList, function(item){
      return item.complete;
    }).length;
  };

  vm.totalTasksPending = function() {
    return $filter("filter")(vm.tasksList, function(item){
      return !item.complete;
    }).length;
  };


  // modal Controller
  // -----------------------------------

  vm.modalOpen = function (editTask) {
    var modalInstance = $modal.open({
      templateUrl: '/myModalContent.html',
      controller: ModalInstanceCtrl,
      scope: $scope,
      resolve: {
        editTask: function() {
          return editTask;
        }
      }
    });

    modalInstance.result.then(function () {
      // Modal dismissed with OK status
    }, function () {
      // Modal dismissed with Cancel status'
    });

  };

  // Please note that $modalInstance represents a modal window (instance) dependency.
  // It is not the same as the $modal service used above.

  var ModalInstanceCtrl = function ($scope, $modalInstance, editTask) {

    $scope.theTask = editTask || {};

    $scope.modalAddTask = function (task) {
      vm.addTask(task);
      $modalInstance.close('closed');
    };

    $scope.modalCancel = function () {
      vm.taskEdition = false;
      $modalInstance.dismiss('cancel');
    };

    $scope.actionText = function() {
      return vm.taskEdition ? 'Edit Task' : 'Add Task';
    };
  };
  ModalInstanceCtrl.$inject = ["$scope", "$modalInstance", "editTask"];

}
TasksController.$inject = ["$scope", "$filter", "$modal"];


/**=========================================================
 * Module: FlatDocDirective.js
 * Creates the flatdoc markup and initializes the plugin
 =========================================================*/

App.directive('flatdoc', ["$document", function($document) {
  'use strict';
  return {
    restrict: "EA",
    template: ["<div role='flatdoc'>",
                  "<div role='flatdoc-menu' ui-scrollfix='+1'></div>",
                  "<div role='flatdoc-content'></div>",
               "</div>"].join('\n'),
    link: function(scope, element, attrs) {

      var $root = $('html, body');
      
      Flatdoc.run({
        fetcher: Flatdoc.file(attrs.src)
      });

      angular.element($document).on('flatdoc:ready', function() {
        
        var docMenu = element.find('[role="flatdoc-menu"]');
        
        docMenu.find('a').on('click', function(e) {
          e.preventDefault(); e.stopPropagation();
          
          var $this = $(this);
          
          docMenu.find('a.active').removeClass('active');
          $this.addClass('active');

          $root.animate({
                scrollTop: $(this.getAttribute('href')).offset().top - ($('.topnavbar').height() + 10)
            }, 800);
        });

      });
    }
  };

}]);

/**=========================================================
 * Module: FormInputController.js
 * Controller for input components
 =========================================================*/

App.controller('FormInputController', FormInputController);

function FormInputController($scope) {
  'use strict';

  // Chosen data
  // ----------------------------------- 

  this.states = [
    'Alabama',
    'Alaska',
    'Arizona',
    'Arkansas',
    'California',
    'Colorado',
    'Connecticut',
    'Delaware',
    'Florida',
    'Georgia',
    'Hawaii',
    'Idaho',
    'Illinois',
    'Indiana',
    'Iowa',
    'Kansas',
    'Kentucky',
    'Louisiana',
    'Maine',
    'Maryland',
    'Massachusetts',
    'Michigan',
    'Minnesota',
    'Mississippi',
    'Missouri',
    'Montana',
    'Nebraska',
    'Nevada',
    'New Hampshire',
    'New Jersey',
    'New Mexico',
    'New York',
    'North Carolina',
    'North Dakota',
    'Ohio',
    'Oklahoma',
    'Oregon',
    'Pennsylvania',
    'Rhode Island',
    'South Carolina',
    'South Dakota',
    'Tennessee',
    'Texas',
    'Utah',
    'Vermont',
    'Virginia',
    'Washington',
    'West Virginia',
    'Wisconsin',
    'Wyoming'
  ];

  // Datepicker
  // ----------------------------------- 

  this.today = function() {
    this.dt = new Date();
  };
  this.today();

  this.clear = function () {
    this.dt = null;
  };

  // Disable weekend selection
  this.disabled = function(date, mode) {
    return false; //( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };

  this.toggleMin = function() {
    this.minDate = this.minDate ? null : new Date();
  };
  this.toggleMin();

  this.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    this.opened = true;
  };

  this.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  this.initDate = new Date('2016-15-20');
  this.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  this.format = this.formats[0];

  // Timepicker
  // ----------------------------------- 
  this.mytime = new Date();

  this.hstep = 1;
  this.mstep = 15;

  this.options = {
    hstep: [1, 2, 3],
    mstep: [1, 5, 10, 15, 25, 30]
  };

  this.ismeridian = true;
  this.toggleMode = function() {
    this.ismeridian = ! this.ismeridian;
  };

  this.update = function() {
    var d = new Date();
    d.setHours( 14 );
    d.setMinutes( 0 );
    this.mytime = d;
  };

  this.changed = function () {
    console.log('Time changed to: ' + this.mytime);
  };

  this.clear = function() {
    this.mytime = null;
  };

  // Input mask
  // ----------------------------------- 

  this.testoption = {
        "mask": "99-9999999",
        "oncomplete": function () {
            console.log();
            console.log(arguments,"oncomplete!this log form controler");
        },
        "onKeyValidation": function () {
            console.log("onKeyValidation event happend! this log form controler");
        }
    };

  //default value
  this.test1 = new Date();

  this.dateFormatOption = {
      parser: function (viewValue) {
          return viewValue ? new Date(viewValue) : undefined;
      },
      formatter: function (modelValue) {
          if (!modelValue) {
              return "";
          }
          var date = new Date(modelValue);
          return (date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate()).replace(/\b(\d)\b/g, "0$1");
      },
      isEmpty: function (modelValue) {
          return !modelValue;
      }
  };

  this.mask = { regex: ["999.999", "aa-aa-aa"]};

  this.regexOption = {
      regex: "[a-zA-Z0-9._%-]+@[a-zA-Z0-9-]+\\.[a-zA-Z]{2,4}"
  };

  this.functionOption = {
   mask: function () {
      return ["[1-]AAA-999", "[1-]999-AAA"];
  }};

  // Bootstrap Wysiwyg
  // ----------------------------------- 
 
  this.editorFontFamilyList = [
    'Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
    'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact',
    'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
    'Times New Roman', 'Verdana'
  ];
  
  this.editorFontSizeList = [
    {value: 1, name: 'Small'},
    {value: 3, name: 'Normal'},
    {value: 5, name: 'Huge'}
  ];
}
FormInputController.$inject = ["$scope"];
/**=========================================================
 * Module: FormValidationController.js
 * Controller for input validation using AngularUI Validate
 =========================================================*/

App.controller('FormValidationController', FormValidationController);

function FormValidationController($scope) {
  'use strict';
  
  this.notBlackListed = function(value) {
    var blacklist = ['bad@domain.com','verybad@domain.com'];
    return blacklist.indexOf(value) === -1;
  };

  this.words = function(value) {
    return value && value.split(' ').length;
  };
}
FormValidationController.$inject = ["$scope"];
/**=========================================================
 * Module: MaskedDirective
 * Initializes masked inputs
 =========================================================*/

App.directive('masked', function() {
  'use strict';
  return {
    restrict: 'A',
    link: function(scope, element, attributes) {
      
      if($.fn.inputmask)
        element.inputmask(attributes.masked);

    }
  };
});

/**=========================================================
 * Module: SearchFormController.js
 * Provides autofill for top navbar search form
 =========================================================*/

App.controller('SearchFormController', ["$scope", "$state", function ($scope, $state) {
  'use strict';
  
  var routes = $state.get(),
      blackList = ['app', 'page']; // routes that don't want to show

  $scope.routeSelected = undefined;

  $scope.states = routes.filter(function(item){

    return ( blackList.indexOf(item.name) < 0 ? true : false);

  }).map(function(item){

    return item.name;

  });

   $scope.onRouteSelect = function ($item, $model, $label) {

    // move to route when match is selected
    if($model) {
      $state.go($model);
      $scope.routeSelected = undefined;
    }

  };
  

}]);


/**=========================================================
 * Module: climacon.js
 * Include any animated weather icon from Climacon
 =========================================================*/

App.directive('climacon', function(){
  'use strict';
  var SVG_PATH = 'app/vendor/animated-climacons/svgs/',
      SVG_EXT = '.svg';

  return {
    restrict: 'EA',
    link: function(scope, element, attrs) {
      
      var color  = attrs.color  || '#000',
          name   = attrs.name   || 'sun',
          width  = attrs.width  || 20,
          height = attrs.height || 20;

      // Request the svg indicated
      $.get(SVG_PATH + name + SVG_EXT).then(svgLoaded, svgError);

      // if request success put it as online svg so we can style it
      function svgLoaded(xml) {
        var svg = angular.element(xml).find('svg');

        svg.css({
          'width':  width,
          'height': height
        });
        svg.find('.climacon_component-stroke').css('fill', color);

        element.append(svg);
      }
      // If fails write a message
      function svgError() {
        element.text('Error loading SVG: ' + name);
      }

    }
  };
});

App.service('language', ["$translate", function($translate) {
  'use strict';
  // Internationalization
  // ----------------------

  var Language = {
    data: {
      // Handles language dropdown
      listIsOpen: false,
      // list of available languages
      available: {
        'en':    'English',
        'es':    'Español',
        'pt':    'Português',
        'zh-cn': '中国简体',
      },
      selected: 'English'
    },
    // display always the current ui language
    init: function () {
      var proposedLanguage = $translate.proposedLanguage() || $translate.use();
      var preferredLanguage = $translate.preferredLanguage(); // we know we have set a preferred one in App.config
      this.data.selected = this.data.available[ (proposedLanguage || preferredLanguage) ];
      return this.data;

    },
    set: function (localeId, ev) {
      // Set the new idiom
      $translate.use(localeId);
      // save a reference for the current language
      this.data.selected = this.data.available[localeId];
      // finally toggle dropdown
      this.data.listIsOpen = ! this.data.listIsOpen;
    }
  };

  return Language;
}]);

/**=========================================================
 * Module: HeaderNavController
 * Controls the header navigation
 =========================================================*/

App.controller('HeaderNavController', ['$scope', function($scope) {
  'use strict';
  $scope.headerMenuCollapsed = true;

  $scope.toggleHeaderMenu = function() {
    $scope.headerMenuCollapsed = !$scope.headerMenuCollapsed;
  };

}]);

/**=========================================================
 * Module: SidebarController
 * Provides functions for sidebar markup generation.
 * Also controls the collapse items states
 =========================================================*/

App.controller('SidebarController', ['$rootScope', '$scope', '$location', '$http', '$timeout', 'appMediaquery', '$window',
  function($rootScope, $scope, $location, $http, $timeout, appMediaquery, $window ){
    'use strict';
    var currentState = $rootScope.$state.current.name;
    var $win  = $($window);
    var $html = $('html');
    var $body = $('body');

    
    // Adjustment on route changes
    $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
      currentState = toState.name;
      // Hide sidebar automatically on mobile
      $('body.aside-toggled').removeClass('aside-toggled');

      $rootScope.$broadcast('closeSidebarMenu');
    });

    // Normalize state on resize to avoid multiple checks
    $win.on('resize', function() {
      if( isMobile() )
        $body.removeClass('aside-collapsed');
      else
        $body.removeClass('aside-toggled');
    });

    $rootScope.$watch('app.sidebar.isCollapsed', function(newValue, oldValue) {
      // Close subnav when sidebar change from collapsed to normal
      $rootScope.$broadcast('closeSidebarMenu');
      $rootScope.$broadcast('closeSidebarSlide');
    });

    // Check item and children active state
    var isActive = function(item) {

      if(!item || !item.sref) return;

      var path = item.sref, prefix = '#';
      if(path === prefix) {
        var foundActive = false;
        angular.forEach(item.subnav, function(value, key) {
          if(isActive(value)) foundActive = true;
        });
        return foundActive;
      }
      else {
        return (currentState === path);
      }
    };

    $scope.getSidebarItemClass = function(item) {
      return (item.type == 'heading' ? 'nav-heading' : '') +
             (isActive(item) ? ' active' : '') ;
    };

    // Handle sidebar collapse items
    // ----------------------------------- 
    var collapseList = [];

    $scope.addCollapse = function($index, item) {
      collapseList[$index] = true; //!isActive(item);
    };

    $scope.isCollapse = function($index) {
      return collapseList[$index];
    };

    $scope.collapseAll = function() {
      collapseAllBut(-1);
    };

    $scope.toggleCollapse = function($index) {

      // States that doesn't toggle drodopwn
      if( (isSidebarCollapsed() && !isMobile()) || isSidebarSlider()  ) return true;
      
      // make sure the item index exists
      if( typeof collapseList[$index] === undefined ) return true;

      collapseAllBut($index);
      collapseList[$index] = !collapseList[$index];
    
      return true;

    };

    function collapseAllBut($index) {
      angular.forEach(collapseList, function(v, i) {
        if($index !== i)
          collapseList[i] = true;
      });
    }

    // Helper checks
    // ----------------------------------- 

    function isMobile() {
      return $win.width() < appMediaquery.tablet;
    }
    function isTouch() {
      return $html.hasClass('touch');
    }
    function isSidebarCollapsed() {
      return $rootScope.app.sidebar.isCollapsed;
    }
    function isSidebarToggled() {
      return $body.hasClass('aside-toggled');
    }
    function isSidebarSlider() {
      return $rootScope.app.sidebar.slide;
    }

}]);

/**=========================================================
 * Module: SidebarDirective
 * Wraps the sidebar. Handles collapsed state and slide
 =========================================================*/

App.directive('sideBar', ['$rootScope', '$window', '$timeout', '$compile', 'appMediaquery', 'support', '$http', '$templateCache',
    function($rootScope, $window, $timeout, $compile, appMediaquery, support, $http, $templateCache) {
  'use strict';

  var $win  = $($window);
  var $html = $('html');
  var $body = $('body');
  var $scope;
  var $sidebar;
  var $sidebarNav;
  var $sidebarButtons;

  return {
    restrict: 'E',
    template: '<nav class="sidebar" ng-transclude></nav>',
    transclude: true,
    replace: true,
    link: function(scope, element, attrs) {

      $scope   = scope;
      $sidebar = element;
      $sidebarNav = element.children('.sidebar-nav');
      $sidebarButtons = element.find('.sidebar-buttons');

      // depends on device the event we use
      var eventName = isTouch() ? 'click' : 'mouseenter' ;
      $sidebarNav.on( eventName, '.nav > li', function() {

        if( isSidebarCollapsed() && !isMobile() ) {
          toggleMenuItem( $(this) );
          if( isTouch() ) {
            sidebarAddBackdrop();
          }
        }

      });

      // Check for click to slide sidebar navigation menu
      $sidebarNav.on('click', '.nav > li', function() {
        if( isSidebarSlider() && !isSidebarCollapsed()) {
          sidebarSliderToggle(this);
        }
      });

      // Check for click to slide sidebar bottom item
      $sidebarButtons.on('click', '.btn-sidebar', function() {
        // call parent method
        $scope.collapseAll();
        // slide sidebar
        sidebarSliderToggle(this);
      });

      // expose a close function to use a go back
      $sidebarNav.on('click', '.sidebar-close', function(){
        sidebarSliderClose();
      });

      // if something ask us to close the sidebar menu
      $scope.$on('closeSidebarMenu', function() {
        sidebarCloseFloatItem();
      });
      // if something ask us to close the sidebar slide
      $scope.$on('closeSidebarSlide', function() {
        sidebarSliderClose();
      });

    }
  };

  // Sidebar slide mode
  // -----------------------------------

  function sidebarSliderClose() {
    if( !$sidebar.hasClass('sidebar-slide')) return;

    if( support.transition ) {
      return $sidebar
        .on(support.transition.end, removeMenuDom)
        .removeClass('sidebar-slide').length;
    }
    else {
      $timeout(removeMenuDom, 500);
      return $sidebar.removeClass('sidebar-slide').length;
    }

    function removeMenuDom() {
      if(support.transition)
        $sidebar.off(support.transition.end);
      $sidebarNav
        .find('.nav-slide').hide()
        .filter('.sidebar-subnav').remove();
    }
  }

  // expect an level 1 li element
  function sidebarSliderToggle(element) {

    var $el = $(element),
        // Find a template
        $item = $el; //$el.siblings('.sidebar-slide-template');
    // if not exists, find a submenu UL
    if( ! $item.hasClass('btn-sidebar'))
      $item = $el.children('ul');
    // make sure other slider are closed
    if( sidebarSliderClose() )
      return;

    if($item.length) {

      var templatePath = $item.attr('compile');
      var newItem, templateContent;

      // Compile content when it contains angular
      if( templatePath ) {
        templateContent = $templateCache.get(templatePath);
        if( templateContent ) {
          prepareItemTemplate( templateContent, templatePath );
        }
        else {
          $http.get(templatePath).success(function(data) {
            // cache the template markup
            $templateCache.put(templatePath, data);
            prepareItemTemplate( data, templatePath );
          });

        }
      }
      else {
        newItem = $item.clone();
        addSlideItemToDom(newItem);
      }
    }
  }

  function prepareItemTemplate(markup, id) {
    if( ! $scope.sbSlideItems ) $scope.sbSlideItems = {};

    if( ! $scope.sbSlideItems[id]  ) {
      // create an element and compile it
      $scope.sbSlideItems[id] = $compile(markup)($scope.$parent);

    }

    // append to dom
    addSlideItemToDom($scope.sbSlideItems[id]);
  }

  function addSlideItemToDom(newItem) {
    // the first the item is not in dom so we add it
    if ( ! newItem.inDom ) {
      newItem.inDom = true;
      newItem = newItem.prependTo($sidebarNav).addClass('nav-slide');
    }
    else {
      // nex time only show a hidden item
      newItem.show();
    }

    $timeout(function() {
      $sidebar.addClass('sidebar-slide')
              .scrollTop(0);
    }, 100);

    // Actives the items
    newItem.on('click.slide.subnav', 'li:not(.sidebar-subnav-header)', function(e){
      e.stopPropagation();
      $(this).off('click.slide.subnav')
        .siblings('li').removeClass('active')
        .end().addClass('active');

    });
  }


  function sidebarCloseFloatItem() {
    $('.dropdown-backdrop').remove();
    $('.sidebar-subnav.nav-floating').remove();
  }

  function sidebarAddBackdrop() {
    var $backdrop = $('<div/>', { 'class': 'dropdown-backdrop'} );
    $backdrop.insertAfter($sidebar).on("click", function () {
      sidebarCloseFloatItem();
    });
  }


  function isTouch() {
    return $html.hasClass('touch');
  }
  function isSidebarCollapsed() {
    return $rootScope.app.sidebar.isCollapsed;
  }
  function isSidebarToggled() {
    return $body.hasClass('aside-toggled');
  }
  function isMobile() {
    return $win.width() < appMediaquery.tablet;
  }
  function isSidebarSlider() {
    return $rootScope.app.sidebar.slide;
  }

}]);

/**=========================================================
 * Module: DemoButtonsController.js
 * Provides a simple demo for buttons actions
 =========================================================*/

App.controller('ButtonsCtrl', ["$scope", function ($scope) {
  'use strict';
  $scope.singleModel = 1;

  $scope.radioModel = 'Middle';

  $scope.checkModel = {
    left: false,
    middle: true,
    right: false
  };

}]);

/**=========================================================
 * Module: DemoDatepickerController.js
 * Provides a simple demo for bootstrap datepicker
 =========================================================*/

App.controller('DatepickerDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.disabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
  $scope.toggleMin();

  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.initDate = new Date('2016-15-20');
  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

}]);

/**=========================================================
 * Module: DemoPaginationController
 * Provides a simple demo for pagination
 =========================================================*/

App.controller('PaginationDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.totalItems = 64;
  $scope.currentPage = 4;

  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    console.log('Page changed to: ' + $scope.currentPage);
  };

  $scope.maxSize = 5;
  $scope.bigTotalItems = 175;
  $scope.bigCurrentPage = 1;
}]);

/**=========================================================
 * Module: ScrollableDirective.js
 * Make a content box scrollable
 =========================================================*/

App.directive('scrollable', function() {
  'use strict';
  return {
    restrict: 'EA',
    link: function(scope, elem, attrs) {
      var defaultHeight = 350;

      attrs.height = attrs.height || defaultHeight;

      elem.slimScroll(attrs);

    }
  };
});

/**=========================================================
 * Module: EmptyAnchorDirective.js
 * Disables null anchor behavior
 =========================================================*/

App.directive('href', function() {
  'use strict';
  return {
    restrict: 'A',
    compile: function(element, attr) {
        return function(scope, element) {
          if((attr.ngClick || attr.href === '' || attr.href === '#')
              && (!element.hasClass('dropdown-toggle')) ){
            element.on('click', function(e){
              e.preventDefault();
              // e.stopPropagation();
            });
          }
        };
      }
   };
});


/**=========================================================
 * Module: ToggleStateDirective.js
 * Toggle a classname from the BODY
 * Elements must have [toggle-state="CLASS-NAME-TO-TOGGLE"]
 * [no-persist] to avoid saving the sate in browser storage
 =========================================================*/

App.directive('toggleState', ['toggleStateService', function(toggle) {
  'use strict';
  
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {

      var $body = angular.element('body');

      $(element)
        .on('click', function (e) {
          e.preventDefault();
          var classname = attrs.toggleState;
          
          if(classname) {
            if( $body.hasClass(classname) ) {
              $body.removeClass(classname);
              if( ! attrs.noPersist)
                toggle.removeState(classname);
            }
            else {
              $body.addClass(classname);
              if( ! attrs.noPersist)
                toggle.addState(classname);
            }
            
          }

      });
    }
  };
  
}]);

/**=========================================================
 * Module: BrowserDetectionService.js
 * Browser detection service
 =========================================================*/

App.service('browser', function(){
  "use strict";

  var matched, browser;

  var uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(opr)[\/]([\w.]+)/.exec( ua ) ||
      /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
      /(version)[ \/]([\w.]+).*(safari)[ \/]([\w.]+)/.exec( ua ) ||
      /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
      /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
      /(msie) ([\w.]+)/.exec( ua ) ||
      ua.indexOf("trident") >= 0 && /(rv)(?::| )([\w.]+)/.exec( ua ) ||
      ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
      [];

    var platform_match = /(ipad)/.exec( ua ) ||
      /(iphone)/.exec( ua ) ||
      /(android)/.exec( ua ) ||
      /(windows phone)/.exec( ua ) ||
      /(win)/.exec( ua ) ||
      /(mac)/.exec( ua ) ||
      /(linux)/.exec( ua ) ||
      /(cros)/i.exec( ua ) ||
      [];

    return {
      browser: match[ 3 ] || match[ 1 ] || "",
      version: match[ 2 ] || "0",
      platform: platform_match[ 0 ] || ""
    };
  };

  matched = uaMatch( window.navigator.userAgent );
  browser = {};

  if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
    browser.versionNumber = parseInt(matched.version);
  }

  if ( matched.platform ) {
    browser[ matched.platform ] = true;
  }

  // These are all considered mobile platforms, meaning they run a mobile browser
  if ( browser.android || browser.ipad || browser.iphone || browser[ "windows phone" ] ) {
    browser.mobile = true;
  }

  // These are all considered desktop platforms, meaning they run a desktop browser
  if ( browser.cros || browser.mac || browser.linux || browser.win ) {
    browser.desktop = true;
  }

  // Chrome, Opera 15+ and Safari are webkit based browsers
  if ( browser.chrome || browser.opr || browser.safari ) {
    browser.webkit = true;
  }

  // IE11 has a new token so we will assign it msie to avoid breaking changes
  if ( browser.rv )
  {
    var ie = "msie";

    matched.browser = ie;
    browser[ie] = true;
  }

  // Opera 15+ are identified as opr
  if ( browser.opr )
  {
    var opera = "opera";

    matched.browser = opera;
    browser[opera] = true;
  }

  // Stock Android browsers are marked as Safari on Android.
  if ( browser.safari && browser.android )
  {
    var android = "android";

    matched.browser = android;
    browser[android] = true;
  }

  // Assign the name and platform variable
  browser.name = matched.browser;
  browser.platform = matched.platform;


  return browser;

});
/**=========================================================
 * Module: ColorsService.js
 * Services to retrieve global colors
 =========================================================*/
 
App.factory('colors', ['appColors', function(appColors) {
  'use strict';
  return {
    byName: function(name) {
      return (appColors[name] || '#fff');
    }
  };

}]);

/**=========================================================
 * Module: SupportService.js
 * Checks for features supports on browser
 =========================================================*/

App.service('support', ["$document", "$window", function($document, $window) {
  'use strict';
  var support = {};
  var doc = $document[0];

  // Check for transition support
  // ----------------------------------- 
  support.transition = (function() {

      var transitionEnd = (function() {

          var element = doc.body || doc.documentElement,
              transEndEventNames = {
                  WebkitTransition: 'webkitTransitionEnd',
                  MozTransition: 'transitionend',
                  OTransition: 'oTransitionEnd otransitionend',
                  transition: 'transitionend'
              }, name;

          for (name in transEndEventNames) {
              if (element.style[name] !== undefined) return transEndEventNames[name];
          }
      }());

      return transitionEnd && { end: transitionEnd };
  })();

  // Check for animation support
  // ----------------------------------- 
  support.animation = (function() {

      var animationEnd = (function() {

          var element = doc.body || doc.documentElement,
              animEndEventNames = {
                  WebkitAnimation: 'webkitAnimationEnd',
                  MozAnimation: 'animationend',
                  OAnimation: 'oAnimationEnd oanimationend',
                  animation: 'animationend'
              }, name;

          for (name in animEndEventNames) {
              if (element.style[name] !== undefined) return animEndEventNames[name];
          }
      }());

      return animationEnd && { end: animationEnd };
  })();

  // Check touch device
  // ----------------------------------- 
  support.touch                 = (
      ('ontouchstart' in window && navigator.userAgent.toLowerCase().match(/mobile|tablet/)) ||
      ($window.DocumentTouch && document instanceof $window.DocumentTouch)  ||
      ($window.navigator['msPointerEnabled'] && $window.navigator['msMaxTouchPoints'] > 0) || //IE 10
      ($window.navigator['pointerEnabled'] && $window.navigator['maxTouchPoints'] > 0) || //IE >=11
      false
  );

  return support;
}]);
/**=========================================================
 * Module: ToggleStateService.js
 * Services to share toggle state functionality
 =========================================================*/

App.service('toggleStateService', ['$rootScope', function($rootScope) {
  'use strict';
  var storageKeyName  = 'toggleState';

  // Helper object to check for words in a phrase //
  var WordChecker = {
    hasWord: function (phrase, word) {
      return new RegExp('(^|\\s)' + word + '(\\s|$)').test(phrase);
    },
    addWord: function (phrase, word) {
      if (!this.hasWord(phrase, word)) {
        return (phrase + (phrase ? ' ' : '') + word);
      }
    },
    removeWord: function (phrase, word) {
      if (this.hasWord(phrase, word)) {
        return phrase.replace(new RegExp('(^|\\s)*' + word + '(\\s|$)*', 'g'), '');
      }
    }
  };

  // Return service public methods
  return {
    // Add a state to the browser storage to be restored later
    addState: function(classname){
      var data = $rootScope.$storage[storageKeyName];
      
      if(!data)  {
        data = classname;
      }
      else {
        data = WordChecker.addWord(data, classname);
      }

      $rootScope.$storage[storageKeyName] = data;
    },

    // Remove a state from the browser storage
    removeState: function(classname){
      var data = $rootScope.$storage[storageKeyName];
      // nothing to remove
      if(!data) return;

      data = WordChecker.removeWord(data, classname);

      $rootScope.$storage[storageKeyName] = data;
    },
    
    // Load the state string and restore the classlist
    restoreState: function($elem) {
      var data = $rootScope.$storage[storageKeyName];
      
      // nothing to restore
      if(!data) return;
      $elem.addClass(data);
    }

  };

}]);


