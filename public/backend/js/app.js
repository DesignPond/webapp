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

var App = angular.module('singular', ['ngRoute', 'ngAnimate', 'flow', 'ngStorage', 'ngCookies', 'ui.bootstrap', 'ui.router', 'oc.lazyLoad', 'cfp.loadingBar', 'ui.utils'] , function($interpolateProvider)
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

App.config(['flowFactoryProvider','$stateProvider','$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', '$ocLazyLoadProvider', 'appDependencies',
    function (flowFactoryProvider,$stateProvider, $urlRouterProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, $ocLazyLoadProvider, appDependencies) {
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

      var url  = location.protocol + "//" + location.host+"/";

      flowFactoryProvider.defaults = {
          target: url + 'upload',
          testChunks:false,
          singleFile: true,
          permanentErrors: [404, 500, 501],
          simultaneousUploads: 4
      };
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

  // Handles hover to open items on
  // collapsed menu
  // -----------------------------------
  function toggleMenuItem($listItem) {

    sidebarCloseFloatItem();

    var ul = $listItem.children('ul');

    if( !ul.length )
      return;

    var navHeader = $('.navbar-header');
    var mar =  $rootScope.app.layout.isFixed ?  parseInt( navHeader.outerHeight(true), 0) : 0;

    var subNav = ul.clone().appendTo( '.sidebar-wrapper' );

    var itemTop = ($listItem.position().top + mar) - $sidebar.scrollTop();
    var vwHeight = $win.height();

    subNav
      .addClass('nav-floating')
      .css({
        position: $rootScope.app.layout.isFixed ? 'fixed' : 'absolute',
        top:      itemTop,
        bottom:   (subNav.outerHeight(true) + itemTop > vwHeight) ? 0 : 'auto'
      });

    subNav.on('mouseleave', function() {
      subNav.remove();
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
 * Module: GoogleMapController.js
 * Google Map plugin controller
 =========================================================*/

App.controller('GoogleMapController', GoogleMapController);

function GoogleMapController($scope) {
  'use strict';
  var vm = this;
  // Demo 1
  // ----------------------------------- 

  $scope.$watch(function(){
    return vm.center;
   }, function(center) {
     if (center) {
       vm.centerLat = center.lat();
       vm.centerLng = center.lng();
     }
  });
  
  this.updateCenter = function(lat, lng) {
    vm.center = new google.maps.LatLng(lat, lng);
  };

  // Demo 2
  // ----------------------------------- 

  this.options = {
    map: {
      center: new google.maps.LatLng(48, -121),
      zoom: 6,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    },
  };
  
  this.volcanoes = [
    {
      id: 0,
      name: 'Mount Rainier',
      img: 'http://www.thetrackerfoundation.org/Images/MountRainier_SM.jpg',
      elevationMeters: 4392,
      location: {
        lat: 46.852947,
        lng: -121.760424
      }
    },
    {
      id: 1,
      name: 'Mount Baker',
      img: 'http://www.destination360.com/north-america/us/washington/images/s/washington-mt-baker-ski.jpg',
      elevationMeters: 3287,
      location: {
        lat: 48.776797,
        lng: -121.814467
      }
    },
    {
      id: 2,
      name: 'Glacier Peak',
      img: 'http://www.rhinoclimbs.com/Images/Glacier.9.jpg',
      elevationMeters: 3207,
      location: {
        lat: 48.111844,
        lng: -121.11412
      }
    }
  ];
  
  this.triggerOpenInfoWindow = function(volcano) {
    vm.markerEvents = [
      {
        event: 'openinfowindow',
        ids: [volcano.id]
      },
    ];
  };

  // Demo 3
  // ----------------------------------- 

  this.options3 = {
    map: {
      center: new google.maps.LatLng(48, -121),
      zoom: 6,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    },
    notselected: {
      icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png'
    },
    selected: {
      icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/yellow-dot.png'
    }
  };

  // add to global scope so the map plugin can see the mutated object
  // when we broadcast the changes
  $scope.volcanoes = this.volcanoes;

  this.getVolcanoOpts = function(volcan) {
    return angular.extend(
     { title: volcan.name },
     volcan.selected ? vm.options3.selected :
        vm.options3.notselected
    );
  };
  
  this.selectVolcano = function(volcan) {
    if (vm.volcan) {
      vm.volcan.selected = false;
    }
    vm.volcan = volcan;
    vm.volcan.selected = true;

    $scope.$broadcast('gmMarkersUpdate', 'volcanoes');

  };

}
GoogleMapController.$inject = ["$scope"];
/**=========================================================
 * Module: VectorMapController.js
 * jVector Maps support
 =========================================================*/

App.controller('VectorMapController', VectorMapController);

function VectorMapController($scope, colors) {
  'use strict';
  var vm = this;
  
  // SERIES & MARKERS FOR WORLD MAP
  // ----------------------------------- 

  this.seriesData = {
    'AU': 15710,    // Australia
    'RU': 17312,    // Russia
    'CN': 123370,    // China
    'US': 12337,     // USA
    'AR': 18613,    // Argentina
    'CO': 12170,   // Colombia
    'DE': 1358,    // Germany
    'FR': 1479,    // France
    'GB': 16311,    // Great Britain
    'IN': 19814,    // India
    'SA': 12137      // Saudi Arabia
  };
  
  this.markersData = [
    { latLng:[41.90, 12.45],  name:'Vatican City'          },
    { latLng:[43.73, 7.41],   name:'Monaco'                },
    { latLng:[-0.52, 166.93], name:'Nauru'                 },
    { latLng:[-8.51, 179.21], name:'Tuvalu'                },
    { latLng:[7.11,171.06],   name:'Marshall Islands'      },
    { latLng:[17.3,-62.73],   name:'Saint Kitts and Nevis' },
    { latLng:[3.2,73.22],     name:'Maldives'              },
    { latLng:[35.88,14.5],    name:'Malta'                 },
    { latLng:[41.0,-71.06],   name:'New England'           },
    { latLng:[12.05,-61.75],  name:'Grenada'               },
    { latLng:[13.16,-59.55],  name:'Barbados'              },
    { latLng:[17.11,-61.85],  name:'Antigua and Barbuda'   },
    { latLng:[-4.61,55.45],   name:'Seychelles'            },
    { latLng:[7.35,134.46],   name:'Palau'                 },
    { latLng:[42.5,1.51],     name:'Andorra'               }
  ];
  
  // set options will be reused later
  this.mapOptions = {
      height:          500,
      map:             'world_mill_en',
      backgroundColor: 'transparent',
      zoomMin:         0,
      zoomMax:         8,
      zoomOnScroll:    false,
      regionStyle: {
        initial: {
          'fill':           colors.byName('gray-dark'),
          'fill-opacity':   1,
          'stroke':         'none',
          'stroke-width':   1.5,
          'stroke-opacity': 1
        },
        hover: {
          'fill-opacity': 0.8
        },
        selected: {
          fill: 'blue'
        },
        selectedHover: {
        }
      },
      focusOn:{ x:0.4, y:0.6, scale: 1},
      markerStyle: {
        initial: {
          fill: colors.byName('warning'),
          stroke: colors.byName('warning')
        }
      },
      onRegionLabelShow: function(e, el, code) {
        if ( vm.seriesData && vm.seriesData[code] )
          el.html(el.html() + ': ' + vm.seriesData[code] + ' visitors');
      },
      markers: vm.markersData,
      series: {
          regions: [{
              values: vm.seriesData,
              scale: [ colors.byName('gray-darker') ],
              normalizeFunction: 'polynomial'
          }]
      },
    };

  // USA MAP
  // ----------------------------------- 
  this.usaMarkersData = [
    {latLng: [33.9783241, -84.4783064],               name: 'Mark_1'},
    {latLng: [30.51220349999999, -97.67312530000001], name: 'Mark_2'},
    {latLng: [39.4014955, -76.6019125],               name: 'Mark_3'},
    {latLng: [33.37857109999999, -86.80439],          name: 'Mark_4'},
    {latLng: [43.1938516, -71.5723953],               name: 'Mark_5'},
    {latLng: [43.0026291, -78.8223134],               name: 'Mark_6'},
    {latLng: [33.836081, -81.1637245],                name: 'Mark_7'},
    {latLng: [41.7435073, -88.0118473],               name: 'Mark_8'},
    {latLng: [39.1031182, -84.5120196],               name: 'Mark_9'},
    {latLng: [41.6661573, -81.339552],                name: 'Mark_10'},
    {latLng: [39.9611755, -82.99879419999999],        name: 'Mark_11'},
    {latLng: [32.735687, -97.10806559999999],         name: 'Mark_12'},
    {latLng: [39.9205411, -105.0866504],              name: 'Mark_13'},
    {latLng: [42.8105356, -83.0790865],               name: 'Mark_14'},
    {latLng: [41.754166, -72.624443],                 name: 'Mark_15'},
    {latLng: [29.7355047, -94.97742740000001],        name: 'Mark_16'},
    {latLng: [39.978371, -86.1180435],                name: 'Mark_17'},
    {latLng: [30.3321838, -81.65565099999999],        name: 'Mark_18'},
    {latLng: [39.0653602, -94.5624426],               name: 'Mark_19'},
    {latLng: [36.0849963, -115.1511364],              name: 'Mark_20'},
    {latLng: [34.0596149, -118.1122679],              name: 'Mark_21'},
    {latLng: [38.3964426, -85.4375574],               name: 'Mark_22'}
  ];

  this.mapOptions2 = angular.extend({}, this.mapOptions,
    {
      map: 'us_mill_en',
      regionStyle: {
        initial: {
          'fill':           colors.byName('info')
        }
      },
      focusOn:{ x:0.5, y:0.5, scale: 1.2},
      markerStyle: {
        initial: {
          fill: colors.byName('turquoise'),
          stroke: colors.byName('turquoise'),
          r: 10
        },
        hover: {
            stroke: colors.byName('success'),
            'stroke-width': 2
          },
      },
      markers: this.usaMarkersData,
      series: {}
    }
  );
}
VectorMapController.$inject = ["$scope", "colors"];

/**=========================================================
 * Module: VectorMapDirective
 * Init jQuery Vector Map plugin
 =========================================================*/

App.directive('vectorMap', function(){
  'use strict';

  return {
    restrict: 'EA',
    scope: {
      mapOptions: '='
    },
    compile: function(tElement, tAttrs, transclude) {
      return {
        post: function(scope, element) {
          var options     = scope.mapOptions,
              mapHeight   = options.height || '300';
          
          element.css('height', mapHeight);
          
          element.vectorMap(options);
        }
      };
    }
  };

});
/**=========================================================
 * Module: AngularTableController.js
 * Controller for ngTables
 =========================================================*/

App.controller('AngularTableController', AngularTableController);

function AngularTableController($scope, $filter, ngTableParams) {
  'use strict';
  var vm = this;

  // SORTING
  // ----------------------------------- 

  var data = [
      {name: "Moroni",  age: 50, money: -10   },
      {name: "Tiancum", age: 43, money: 120   },
      {name: "Jacob",   age: 27, money: 5.5   },
      {name: "Nephi",   age: 29, money: -54   },
      {name: "Enos",    age: 34, money: 110   },
      {name: "Tiancum", age: 43, money: 1000  },
      {name: "Jacob",   age: 27, money: -201  },
      {name: "Nephi",   age: 29, money: 100   },
      {name: "Enos",    age: 34, money: -52.5 },
      {name: "Tiancum", age: 43, money: 52.1  },
      {name: "Jacob",   age: 27, money: 110   },
      {name: "Nephi",   age: 29, money: -55   },
      {name: "Enos",    age: 34, money: 551   },
      {name: "Tiancum", age: 43, money: -1410 },
      {name: "Jacob",   age: 27, money: 410   },
      {name: "Nephi",   age: 29, money: 100   },
      {name: "Enos",    age: 34, money: -100  }
  ];

  vm.tableParams = new ngTableParams({
      page: 1,            // show first page
      count: 10,          // count per page
      sorting: {
          name: 'asc'     // initial sorting
      }
  }, {
      total: data.length, // length of data
      getData: function($defer, params) {
          // use build-in angular filter
          var orderedData = params.sorting() ?
                  $filter('orderBy')(data, params.orderBy()) :
                  data;
  
          $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
      }
  });

  // FILTERS
  // ----------------------------------- 

  vm.tableParams2 = new ngTableParams({
      page: 1,            // show first page
      count: 10,          // count per page
      filter: {
          name: '',
          age: ''
          // name: 'M'       // initial filter
      }
  }, {
      total: data.length, // length of data
      getData: function($defer, params) {
          // use build-in angular filter
          var orderedData = params.filter() ?
                 $filter('filter')(data, params.filter()) :
                 data;

          vm.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

          params.total(orderedData.length); // set total for recalc pagination
          $defer.resolve(vm.users);
      }
  });

  // SELECT ROWS
  // ----------------------------------- 

  vm.data = data;

  vm.tableParams3 = new ngTableParams({
      page: 1,            // show first page
      count: 10          // count per page
  }, {
      total: data.length, // length of data
      getData: function ($defer, params) {
          // use build-in angular filter
          var filteredData = params.filter() ?
                  $filter('filter')(data, params.filter()) :
                  data;
          var orderedData = params.sorting() ?
                  $filter('orderBy')(filteredData, params.orderBy()) :
                  data;

          params.total(orderedData.length); // set total for recalc pagination
          $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
      }
  });

  vm.changeSelection = function(user) {
      // console.info(user);
  };

  // EXPORT CSV
  // -----------------------------------  

  var data4 = [{name: "Moroni", age: 50},
      {name: "Tiancum", age: 43},
      {name: "Jacob", age: 27},
      {name: "Nephi", age: 29},
      {name: "Enos", age: 34},
      {name: "Tiancum", age: 43},
      {name: "Jacob", age: 27},
      {name: "Nephi", age: 29},
      {name: "Enos", age: 34},
      {name: "Tiancum", age: 43},
      {name: "Jacob", age: 27},
      {name: "Nephi", age: 29},
      {name: "Enos", age: 34},
      {name: "Tiancum", age: 43},
      {name: "Jacob", age: 27},
      {name: "Nephi", age: 29},
      {name: "Enos", age: 34}];

  vm.tableParams4 = new ngTableParams({
      page: 1,            // show first page
      count: 10           // count per page
  }, {
      total: data4.length, // length of data4
      getData: function($defer, params) {
          $defer.resolve(data4.slice((params.page() - 1) * params.count(), params.page() * params.count()));
      }
  });

}
AngularTableController.$inject = ["$scope", "$filter", "ngTableParams"];

/**=========================================================
 * Module: heckAllTableDirective
 * Allows to use a checkbox to check all the rest in the same
 * columns in a Bootstrap table
 =========================================================*/

App.directive('checkAll', function() {
  'use strict';
  
  return {
    restrict: 'A',
    controller: ["$scope", "$element", function($scope, $element){
      
      $element.on('change', function() {
        var $this = $(this),
            index= $this.index() + 1,
            checkbox = $this.find('input[type="checkbox"]'),
            table = $this.parents('table');
        // Make sure to affect only the correct checkbox column
        table.find('tbody > tr > td:nth-child('+index+') input[type="checkbox"]')
          .prop('checked', checkbox[0].checked);

      });
    }]
  };

});
/**=========================================================
 * Module: DemoResponsiveTableController.js
 * Controller for responsive tables components
 =========================================================*/

App.controller("ResponsiveTableController", ['$scope', 'colors', function($scope, colors) {
  'use strict';

  $scope.sparkOps1 = {
    barColor: colors.byName('primary')
  };
  $scope.sparkOps2 = {
    barColor: colors.byName('info')
  };
  $scope.sparkOps3 = {
    barColor: colors.byName('turquoise')
  };

  $scope.sparkData1 = [1,2,3,4,5,6,7,8,9];
  $scope.sparkData2 = [1,2,3,4,5,6,7,8,9];
  $scope.sparkData3 = [1,2,3,4,5,6,7,8,9];
}]);
/**=========================================================
 * Module: demo-alerts.js
 * Provides a simple demo for pagination
 =========================================================*/

App.controller('AlertDemoCtrl', ["$scope", function AlertDemoCtrl($scope) {
  'use strict';

  $scope.alerts = [
    { type: 'danger', msg: 'Oh snap! Change a few things up and try submitting again.' },
    { type: 'warning', msg: 'Well done! You successfully read this important alert message.' }
  ];

  $scope.addAlert = function() {
    $scope.alerts.push({msg: 'Another alert!'});
  };

  $scope.closeAlert = function(index) {
    $scope.alerts.splice(index, 1);
  };

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
 * Module: DemoCarouselController
 * Provides a simple demo for bootstrap ui carousel
 =========================================================*/

App.controller('CarouselDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.myInterval = 5000;
  var slides = $scope.slides = [];

  $scope.addSlide = function(index) {
    var newWidth = 800 + slides.length;
    index = index || (Math.floor((Math.random() * 2))+1);
    slides.push({
      image: 'app/img/bg' + index + '.jpg',
      text: "Nulla viverra dignissim metus ac placerat."
    });
  };
  for (var i=1; i<=3; i++) {
    $scope.addSlide(i);
  }
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
 * Module: DemoPopoverController.js
 * Provides a simple demo for popovers
 =========================================================*/

App.controller('PopoverDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.dynamicPopover = 'Hello, World!';
  $scope.dynamicPopoverTitle = 'Title';

}]);
/**=========================================================
 * Module: DemoProgressController.js
 * Provides a simple demo to animate progress bar
 =========================================================*/

App.controller('ProgressDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.max = 200;

  $scope.random = function() {
    var value = Math.floor((Math.random() * 100) + 1);
    var type;

    if (value < 25) {
      type = 'success';
    } else if (value < 50) {
      type = 'info';
    } else if (value < 75) {
      type = 'warning';
    } else {
      type = 'danger';
    }

    $scope.showWarning = (type === 'danger' || type === 'warning');

    $scope.dynamic = value;
    $scope.type = type;
  };
  $scope.random();

  $scope.randomStacked = function() {
    $scope.stacked = [];
    var types = ['success', 'info', 'warning', 'danger'];

    for (var i = 0, n = Math.floor((Math.random() * 4) + 1); i < n; i++) {
        var index = Math.floor((Math.random() * 4));
        $scope.stacked.push({
          value: Math.floor((Math.random() * 30) + 1),
          type: types[index]
        });
    }
  };
  $scope.randomStacked();
}]);
/**=========================================================
 * Module: DemoRatingController.js
 * Provides a demo for ratings UI
 =========================================================*/

App.controller('RatingDemoCtrl', ["$scope", function ($scope) {
  'use strict';

  $scope.rate = 7;
  $scope.max = 10;
  $scope.isReadonly = false;

  $scope.hoveringOver = function(value) {
    $scope.overStar = value;
    $scope.percent = 100 * (value / $scope.max);
  };

  $scope.ratingStates = [
    {stateOn: 'fa fa-check', stateOff: 'fa fa-check-circle'},
    {stateOn: 'fa fa-star', stateOff: 'fa fa-star-o'},
    {stateOn: 'fa fa-heart', stateOff: 'fa fa-ban'},
    {stateOn: 'fa fa-heart'},
    {stateOff: 'fa fa-power-off'}
  ];

}]);
/**=========================================================
 * Module: DemoTimepickerController
 * Provides a simple demo for bootstrap ui timepicker
 =========================================================*/

App.controller('TimepickerDemoCtrl', ["$scope", function ($scope) {
  'use strict';
  $scope.mytime = new Date();

  $scope.hstep = 1;
  $scope.mstep = 15;

  $scope.options = {
    hstep: [1, 2, 3],
    mstep: [1, 5, 10, 15, 25, 30]
  };

  $scope.ismeridian = true;
  $scope.toggleMode = function() {
    $scope.ismeridian = ! $scope.ismeridian;
  };

  $scope.update = function() {
    var d = new Date();
    d.setHours( 14 );
    d.setMinutes( 0 );
    $scope.mytime = d;
  };

  $scope.changed = function () {
    console.log('Time changed to: ' + $scope.mytime);
  };

  $scope.clear = function() {
    $scope.mytime = null;
  };
}]);

/**=========================================================
 * Module: DemoToasterController.js
 * Demos for toaster notifications
 =========================================================*/

App.controller('ToasterDemoCtrl', ['$scope', 'toaster', function($scope, toaster) {
  'use strict';
  $scope.toaster = {
      type:  'success',
      title: 'Title',
      text:  'Message'
  };

  $scope.pop = function() {
    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
  };

}]);
/**=========================================================
 * Module: DemoTooltipController.js
 * Provides a simple demo for tooltip
 =========================================================*/
App.controller('TooltipDemoCtrl', ["$scope", function ($scope) {
  'use strict';
  $scope.dynamicTooltip = 'Hello, World!';
  $scope.dynamicTooltipText = 'dynamic';
  $scope.htmlTooltip = 'I\'ve been made <b>bold</b>!';

}]);
/**=========================================================
 * Module: DemoTypeaheadController.js
 * Provides a simple demo for typeahead
 =========================================================*/

App.controller('TypeaheadCtrl', ["$scope", "$http", function ($scope, $http) {
  'use strict';
  $scope.selected = undefined;
  $scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
  // Any function returning a promise object can be used to load values asynchronously
  $scope.getLocation = function(val) {
    return $http.get('http://maps.googleapis.com/maps/api/geocode/json', {
      params: {
        address: val,
        sensor: false
      }
    }).then(function(res){
      var addresses = [];
      angular.forEach(res.data.results, function(item){
        addresses.push(item.formatted_address);
      });
      return addresses;
    });
  };

  $scope.statesWithFlags = [{'name':'Alabama','flag':'5/5c/Flag_of_Alabama.svg/45px-Flag_of_Alabama.svg.png'},{'name':'Alaska','flag':'e/e6/Flag_of_Alaska.svg/43px-Flag_of_Alaska.svg.png'},{'name':'Arizona','flag':'9/9d/Flag_of_Arizona.svg/45px-Flag_of_Arizona.svg.png'},{'name':'Arkansas','flag':'9/9d/Flag_of_Arkansas.svg/45px-Flag_of_Arkansas.svg.png'},{'name':'California','flag':'0/01/Flag_of_California.svg/45px-Flag_of_California.svg.png'},{'name':'Colorado','flag':'4/46/Flag_of_Colorado.svg/45px-Flag_of_Colorado.svg.png'},{'name':'Connecticut','flag':'9/96/Flag_of_Connecticut.svg/39px-Flag_of_Connecticut.svg.png'},{'name':'Delaware','flag':'c/c6/Flag_of_Delaware.svg/45px-Flag_of_Delaware.svg.png'},{'name':'Florida','flag':'f/f7/Flag_of_Florida.svg/45px-Flag_of_Florida.svg.png'},{'name':'Georgia','flag':'5/54/Flag_of_Georgia_%28U.S._state%29.svg/46px-Flag_of_Georgia_%28U.S._state%29.svg.png'},{'name':'Hawaii','flag':'e/ef/Flag_of_Hawaii.svg/46px-Flag_of_Hawaii.svg.png'},{'name':'Idaho','flag':'a/a4/Flag_of_Idaho.svg/38px-Flag_of_Idaho.svg.png'},{'name':'Illinois','flag':'0/01/Flag_of_Illinois.svg/46px-Flag_of_Illinois.svg.png'},{'name':'Indiana','flag':'a/ac/Flag_of_Indiana.svg/45px-Flag_of_Indiana.svg.png'},{'name':'Iowa','flag':'a/aa/Flag_of_Iowa.svg/44px-Flag_of_Iowa.svg.png'},{'name':'Kansas','flag':'d/da/Flag_of_Kansas.svg/46px-Flag_of_Kansas.svg.png'},{'name':'Kentucky','flag':'8/8d/Flag_of_Kentucky.svg/46px-Flag_of_Kentucky.svg.png'},{'name':'Louisiana','flag':'e/e0/Flag_of_Louisiana.svg/46px-Flag_of_Louisiana.svg.png'},{'name':'Maine','flag':'3/35/Flag_of_Maine.svg/45px-Flag_of_Maine.svg.png'},{'name':'Maryland','flag':'a/a0/Flag_of_Maryland.svg/45px-Flag_of_Maryland.svg.png'},{'name':'Massachusetts','flag':'f/f2/Flag_of_Massachusetts.svg/46px-Flag_of_Massachusetts.svg.png'},{'name':'Michigan','flag':'b/b5/Flag_of_Michigan.svg/45px-Flag_of_Michigan.svg.png'},{'name':'Minnesota','flag':'b/b9/Flag_of_Minnesota.svg/46px-Flag_of_Minnesota.svg.png'},{'name':'Mississippi','flag':'4/42/Flag_of_Mississippi.svg/45px-Flag_of_Mississippi.svg.png'},{'name':'Missouri','flag':'5/5a/Flag_of_Missouri.svg/46px-Flag_of_Missouri.svg.png'},{'name':'Montana','flag':'c/cb/Flag_of_Montana.svg/45px-Flag_of_Montana.svg.png'},{'name':'Nebraska','flag':'4/4d/Flag_of_Nebraska.svg/46px-Flag_of_Nebraska.svg.png'},{'name':'Nevada','flag':'f/f1/Flag_of_Nevada.svg/45px-Flag_of_Nevada.svg.png'},{'name':'New Hampshire','flag':'2/28/Flag_of_New_Hampshire.svg/45px-Flag_of_New_Hampshire.svg.png'},{'name':'New Jersey','flag':'9/92/Flag_of_New_Jersey.svg/45px-Flag_of_New_Jersey.svg.png'},{'name':'New Mexico','flag':'c/c3/Flag_of_New_Mexico.svg/45px-Flag_of_New_Mexico.svg.png'},{'name':'New York','flag':'1/1a/Flag_of_New_York.svg/46px-Flag_of_New_York.svg.png'},{'name':'North Carolina','flag':'b/bb/Flag_of_North_Carolina.svg/45px-Flag_of_North_Carolina.svg.png'},{'name':'North Dakota','flag':'e/ee/Flag_of_North_Dakota.svg/38px-Flag_of_North_Dakota.svg.png'},{'name':'Ohio','flag':'4/4c/Flag_of_Ohio.svg/46px-Flag_of_Ohio.svg.png'},{'name':'Oklahoma','flag':'6/6e/Flag_of_Oklahoma.svg/45px-Flag_of_Oklahoma.svg.png'},{'name':'Oregon','flag':'b/b9/Flag_of_Oregon.svg/46px-Flag_of_Oregon.svg.png'},{'name':'Pennsylvania','flag':'f/f7/Flag_of_Pennsylvania.svg/45px-Flag_of_Pennsylvania.svg.png'},{'name':'Rhode Island','flag':'f/f3/Flag_of_Rhode_Island.svg/32px-Flag_of_Rhode_Island.svg.png'},{'name':'South Carolina','flag':'6/69/Flag_of_South_Carolina.svg/45px-Flag_of_South_Carolina.svg.png'},{'name':'South Dakota','flag':'1/1a/Flag_of_South_Dakota.svg/46px-Flag_of_South_Dakota.svg.png'},{'name':'Tennessee','flag':'9/9e/Flag_of_Tennessee.svg/46px-Flag_of_Tennessee.svg.png'},{'name':'Texas','flag':'f/f7/Flag_of_Texas.svg/45px-Flag_of_Texas.svg.png'},{'name':'Utah','flag':'f/f6/Flag_of_Utah.svg/45px-Flag_of_Utah.svg.png'},{'name':'Vermont','flag':'4/49/Flag_of_Vermont.svg/46px-Flag_of_Vermont.svg.png'},{'name':'Virginia','flag':'4/47/Flag_of_Virginia.svg/44px-Flag_of_Virginia.svg.png'},{'name':'Washington','flag':'5/54/Flag_of_Washington.svg/46px-Flag_of_Washington.svg.png'},{'name':'West Virginia','flag':'2/22/Flag_of_West_Virginia.svg/46px-Flag_of_West_Virginia.svg.png'},{'name':'Wisconsin','flag':'2/22/Flag_of_Wisconsin.svg/45px-Flag_of_Wisconsin.svg.png'},{'name':'Wyoming','flag':'b/bc/Flag_of_Wyoming.svg/43px-Flag_of_Wyoming.svg.png'}];

}]);
/**=========================================================
 * Module: ModalController
 * Provides a simple way to implement bootstrap modals from templates
 =========================================================*/

App.controller('ModalController', ["$scope", "$modal", "$log", function ($scope, $modal, $log) {
  'use strict';
  $scope.open = function (size) {

    var modalInstance = $modal.open({
      templateUrl: '/myModalContent.html',
      controller: ModalInstanceCtrl,
      size: size
    });

    var state = $('#modal-state');
    modalInstance.result.then(function () {
      state.text('Modal dismissed with OK status');
    }, function () {
      state.text('Modal dismissed with Cancel status');
    });
  };

  // Please note that $modalInstance represents a modal window (instance) dependency.
  // It is not the same as the $modal service used above.

  var ModalInstanceCtrl = function ($scope, $modalInstance) {

    $scope.ok = function () {
      $modalInstance.close('closed');
    };

    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
  };
  ModalInstanceCtrl.$inject = ["$scope", "$modalInstance"];

}]);

/**=========================================================
 * Module: NotificationController.js
 * Initializes the notifications system
 =========================================================*/

App.controller('NotificationController', ["$scope", "$routeParams", function($scope, $routeParams){
  'use strict';
  $scope.autoplace = function (context, source) {
    //return (predictTooltipTop(source) < 0) ?  "bottom": "top";
    var pos = 'top';
    if(predictTooltipTop(source) < 0)
      pos = 'bottom';
    if(predictTooltipLeft(source) < 0)
      pos = 'right';
    return pos;
  };

  // Predicts tooltip top position 
  // based on the trigger element
  function predictTooltipTop(el) {
    var top = el.offsetTop;
    var height = 40; // asumes ~40px tooltip height

    while(el.offsetParent) {
      el = el.offsetParent;
      top += el.offsetTop;
    }
    return (top - height) - (window.pageYOffset);
  }

  // Predicts tooltip top position 
  // based on the trigger element
  function predictTooltipLeft(el) {
    var left = el.offsetLeft;
    var width = el.offsetWidth;

    while(el.offsetParent) {
      el = el.offsetParent;
      left += el.offsetLeft;
    }
    return (left - width) - (window.pageXOffset);
  }

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
 * Module: TitleCaseFilter.js
 * Convert any case to title
 =========================================================*/

App.filter('titlecase', function() {
  'use strict';
  return function(s) {
      s = ( s === undefined || s === null ) ? '' : s;
      return s.toString().toLowerCase().replace( /\b([a-z])/g, function(ch) {
          return ch.toUpperCase();
      });
  };
});
/**=========================================================
 * Module: AnimateEnabledDirective.js
 * Enable or disables ngAnimate for element with directive
 =========================================================*/

App.directive('animateEnabled', ['$animate', function ($animate) {
  'use strict';
  return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      scope.$watch(function () {
        return scope.$eval(attrs.animateEnabled, scope);
      }, function (newValue) {
        $animate.enabled(!!newValue, element);
      });
    }
  };
}]);
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
 * Module: ResetKeyDirective.js
 * Removes a key from the browser storage via element click
 =========================================================*/

App.directive('resetKey',  ['$state', '$rootScope', function($state, $rootScope) {
  'use strict';

  return {
    restrict: 'EA',
    link: function(scope, element, attrs) {
      
      var resetKey = attrs.resetKey;

      element.on('click', function (e) {
          e.preventDefault();

          if(resetKey) {
            delete $rootScope.$storage[resetKey];
            $state.go($state.current, {}, {reload: true});
          }
          else {
            $.error('No storage key specified for reset.');
          }
      });
    }
  };

}]);
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
/**=========================================================
 * Module: TouchDragService.js
 * Services to add touch drag to a dom element
 =========================================================*/

App.service('touchDrag', ['$document', 'browser', function($document, browser) {
  'use strict';
  return {
    touchHandler: function (event) {
        var touch = event.changedTouches[0];

        var simulatedEvent = document.createEvent("MouseEvent");
            simulatedEvent.initMouseEvent({
            touchstart: "mousedown",
            touchmove: "mousemove",
            touchend: "mouseup"
        }[event.type], true, true, window, 1,
            touch.screenX, touch.screenY,
            touch.clientX, touch.clientY, false,
            false, false, false, 0, null);

        touch.target.dispatchEvent(simulatedEvent);
        event.preventDefault();
    },
    addTo: function (element) {
        element = element || $document;
        if(browser.mobile) {
          element.addEventListener("touchstart", this.touchHandler, true);
          element.addEventListener("touchmove", this.touchHandler, true);
          element.addEventListener("touchend", this.touchHandler, true);
          element.addEventListener("touchcancel", this.touchHandler, true);
        }
    }
  };
}]);