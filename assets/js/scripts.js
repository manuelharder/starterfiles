function debounce(func, wait, immediate) {

    var timeout;
    return function () {
        var context = this,
            args = arguments;
        var later = function later() {
            timeout = null;
            if (!immediate) {
                func.apply(context, args);
            }
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) {
            func.apply(context, args);
        }
    };
};

var Observer = {}, Manager = {}, MyModules = {};

var MobileNavController = function () {
    var _this11 = this;

    var cf = {
        _btn: document.querySelector("#mToggle"),
        _target: document.querySelector("#mobile-nav"),
        activeClass: ['nav-mobile-active'],
        transClass: 'nav-mobile-transiting',
        _html: document.querySelector("html")
    };

    var IS_OPEN = false;    

    this.open = function () {

        [ cf.activeClass[0], cf.transClass ].forEach(function (el) {
            cf._html.classList.add(el);
        });
        cf._target.style.paddingTop = 0;
        cf._target.scrollTop = 0;
        IS_OPEN = true;
        document.querySelector("body").classList.remove('scrolled');
    };

    this.close = function () {
        cf._html.classList.add(cf.transClass);
        cf.activeClass.forEach(function (el) {
            cf._html.classList.remove(el);
        });
        IS_OPEN = false;
    };

    cf._target.addEventListener("transitionend", function (e) {

        cf._html.classList.remove(cf.transClass);
    });

    // Helper variable used to prevent firing btn click event multiple times
    var flag = false;

    cf._btn.addEventListener("click", function (e) {

        if (!flag) {
            flag = true;
            setTimeout(function () {
                flag = false;
            }, 100);
            cf._html.classList.contains(cf.activeClass[0]) ? _this11.close() : _this11.open();
        }

        return false;
    });
};

MyModules.ScrollController = function () {
    var _this = this;

    var self = this;

    this.vars = {

        scrollTop: document.body.scrollTop || document.documentElement.scrollTop,
        windowHeight: window.innerHeight,
        lastScrollTop: 0,
        scrollDirection: "down"
    };

    // functions array of the observer
    this.arrHandlers = [];

    //#### subscribe to the scroll event
    this.subscribe = function (fn) {
        _this.arrHandlers.push(fn);
    };

    this.unsubscribe = function (fn) {

        _this.arrHandlers = _this.arrHandlers.filter(function (item) {
            if (item !== fn) {
                return item;
            }
        });
    }, this.callScrollListener = function () {

        // on resize or on initalize reset
        _this.vars.windowHeight = window.innerHeight;

        // notify the observer on page load or when resized
        self.fire(true);

        window.removeEventListener("scroll", self.scrollFunction, false);

        window.addEventListener("scroll", self.scrollFunction, false);
    };

    this.scrollFunction = function () {

        self.vars.scrollTop = document.body.scrollTop || document.documentElement.scrollTop;

        if (self.vars.scrollTop > self.vars.lastScrollTop) {
            self.vars.scrollDirection = "down";
        } else {
            self.vars.scrollDirection = "up";
        }

        self.vars.lastScrollTop = self.vars.scrollTop;

        // notify the observer on scroll
        self.fire(false);
    };

    this.fire = function (reset) {

        if (self.arrHandlers instanceof Array) {

            _this.arrHandlers.forEach(function (item) {

                try {
                    item.init.call(item, self.vars, reset);
                } catch (e) {}
            });
        }
    };

    // when all the observer are set (global and page specific)
    this.finalize = function () {


        window.onload = function () {

            self.callScrollListener();

            try {

                window.addEventListener("orientationchange", self.myDebouncedFunc);

                window.onresize = self.myDebouncedFunc;
            } catch (e) {}
        };
    };

    this.myDebouncedFunc = debounce(function () {
        self.callScrollListener();
    }, 200);
};



Observer.ScrollObserver_PageScrolled = function() {
        
    var self = this;

    this.init = function(_vars, reset) {

        if (reset) { self.item = document.querySelector("body"); }

        self.execute(_vars);
    };

    this.execute = function(_vars) {

        if (_vars.scrollTop > 50) {

            if (!self.item.classList.contains("scrolled")) {
                self.item.classList.add("scrolled");
            }
        }   
        else {
            if (self.item.classList.contains("scrolled")) {
                self.item.classList.remove("scrolled");
            }
        }   
    };
};



Observer.ScrollObserver_FadeInBlocks = function() {
        
    var self = this;

    this.init = function(_vars, reset) {

        // reset on page load or when resized
        if (reset) { self.items = document.querySelectorAll(".js-fade"); }

        self.execute(_vars);
    };

    this.execute = function(_vars) {
        NodeList.prototype.forEach = Array.prototype.forEach;

        if (self.items) {

            self.items.forEach(function(el) {

                var topOffset = el.getBoundingClientRect().top;

                if ((_vars.windowHeight/4)*3 > topOffset) {

                    if (!el.classList.contains("js-in")) {
                        el.classList.add("js-in");
                    }
                }
               
            });
        }
    };
};


( function( $ ) {

    
    "use strict"; 
    
    var Router = {

        // All pages
        common: {
            
            init: function() {
                // Javascript to be fired on every page


                try {

                    var MobileNav = new MobileNavController();

                } catch(e) {}


                Manager.ScrollController = new MyModules.ScrollController();

                Manager.ScrollController.subscribe(new Observer.ScrollObserver_FadeInBlocks());

                Manager.ScrollController.subscribe(new Observer.ScrollObserver_PageScrolled());

                Manager.ScrollController.finalize();

            }
        }
    }

    var UTIL = {

        fire: function(func, funcname, args) {
            var namespace = Router;
            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function() {
            UTIL.fire('common');

            document.body.className.replace(/-/g, '_').split(/\s+/).forEach(function(classN) {

                UTIL.fire(classN);
            });

        }

    };

    document.addEventListener('DOMContentLoaded', UTIL.loadEvents, false);

    
} )( jQuery );
