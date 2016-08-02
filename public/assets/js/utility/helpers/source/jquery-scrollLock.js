/*!
 * Scroll Lock v1.1.1
 * https://github.com/MohammadYounes/jquery-scrollLock
 *
 * Copyright (c) 2014 Mohammad Younes
 * Licensed under the MIT license.
 */
(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function ($) {

  var eventName = "onmousewheel" in window ? (("ActiveXObject" in window) ? "wheel" : "mousewheel") : "DOMMouseScroll";
  var eventNamespace = ".scrollLock";

  var old = $.fn.scrollLock;
  $.fn.scrollLock = function (toggle, selector, force) {

    if (typeof selector !== 'string')
      selector = null;

    if ((toggle !== undefined && !toggle) || toggle === 'off')
      return this.each(function () {
        $(this).off(eventNamespace);
      });
    else
      return this.each(function () {
        $(this).on(eventName + eventNamespace, selector, function (event) {
          //allow zooming
          if (!event.ctrlKey) {
            var $this = $(this);
            if (force === true || hasVerticalScroll($this)) {
              //Support for nested scrollable blocks (see https://github.com/MohammadYounes/jquery-scrollLock/issues/4)
              event.stopPropagation();
              var scrollTop = $this.scrollTop(),
                  scrollHeight = $this.prop('scrollHeight'),
                  clientHeight = $this.prop('clientHeight'),
                  delta = event.originalEvent.wheelDelta || (-1 * event.originalEvent.detail) || (-1 * event.originalEvent.deltaY),
                  deltaY = 0
              ;
              if (event.type === "wheel") {
                var ratio = $this.height() / $(window).height();
                deltaY = event.originalEvent.deltaY * ratio;
              }
              if (delta > 0 && scrollTop + deltaY <= 0 || delta < 0 && scrollTop + deltaY >= scrollHeight - clientHeight) {
                event.preventDefault();
                if (deltaY)
                  $this.scrollTop(scrollTop + deltaY);
              }
            }
          }
        });
      });
  };
  function hasVerticalScroll($element) {
    var clientWidth = $element.prop('clientWidth'),
        offsetWidth = $element.prop('offsetWidth'),
        borderRightWidth = parseInt($element.css('border-right-width'), 10),
        borderLeftWidth = parseInt($element.css('border-left-width'), 10)
    ;

    return clientWidth + borderLeftWidth + borderRightWidth < offsetWidth;
  }
  // no conflict
  $.fn.scrollLock.noConflict = function () {
    $.fn.scrollLock = old;
    return this;
  };
}));
