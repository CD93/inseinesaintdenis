(function($) {
    var NavMobile = function (element) {
        this.element = element;
        this.header = $("header");
        this.searchToggle = this.header.find(".open-menu-search");
        this.navToggle = this.header.find(".nav-toggle");
        this.subNavToggle = this.header.find(".menu-item--expander");
        this.backBtn = this.header.find(".back-btn");
        this.profilBtn = this.header.find(".block-profil--link");
        this.currentSubMenu;

        this.toggleProfil = this.toggleProfil.bind(this);
        this.toggleNav = this.toggleNav.bind(this);
        this.toggleSubNav = this.toggleSubNav.bind(this);
        this.hideSubNav = this.hideSubNav.bind(this);
        this.compleShowNav = this.compleShowNav.bind(this);

        this.profilBtn.on('click', this.toggleProfil);
        this.navToggle.on('click', this.toggleNav);
        this.searchToggle.on('click', this.toggleNav);
        this.subNavToggle.on('click', this.toggleSubNav);
        this.backBtn.on('click', this.toggleSubNav);

    };

    NavMobile.prototype = {
        toggleProfil: function() {
            if(this.header.hasClass("menu-profil-open")) {
                this.header.removeClass("menu-profil-open");
            } else {
                this.header.addClass("menu-profil-open");
            }
        },
        toggleNav: function() {
            var self = this;

            if(this.header.hasClass("menu-open")) {
                this.element.removeClass("open");
                this.header.removeClass("menu-open");
            } else {
                this.element.addClass("open");
                setTimeout(self.compleShowNav, 0);
            }
        },
        compleShowNav: function(event) {

            this.header.addClass("menu-open");
        },
        toggleSubNav: function(event) {
            var self = this;
            if(this.currentSubMenu == undefined) {
                var currentTarget = $(event.currentTarget);
                this.currentSubMenu = currentTarget.attr("aria-controls");
            }

            if(this.header.hasClass("sub-menu-open")) {
                setTimeout(self.hideSubNav, 300);
            } else {
                $("#" + this.currentSubMenu).addClass("open");
                this.header.addClass("sub-menu-open");
            }
        },
        hideSubNav: function(event) {
            $("#" + this.currentSubMenu).removeClass("open");
            this.header.removeClass("sub-menu-open");
            this.currentSubMenu = undefined;
        }
    }

    window.NavMobile = NavMobile;


})(jQuery);
