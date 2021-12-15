/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/blog/blog.js ***!
  \***********************************/
$("#list-view").hide();
$("#view_id").click(function () {
  $(this).toggleClass("fa-th-large fa-list");

  if ($(this).hasClass("fa-th-large")) {
    $("#list-view").hide();
    $("#grid-view").show();
  } else {
    $("#list-view").show();
    $("#grid-view").hide();
  }
});

(function ($, document, window, viewport) {
  var sticky = function sticky() {
    if (viewport.current() == 'md') {
      alert(viewport.current());
      $('#collapseSidebar').addClass('show');
    }

    if (viewport.is("lg")) {
      $('#sidebar').addClass('sticky-top');
      $('#collapseSidebar').addClass('show');
    }
  };

  $(document).ready(function () {
    sticky();
  });
  $(window).resize(viewport.changed(function () {
    sticky();
  }));
})(jQuery, document, window, ResponsiveBootstrapToolkit);
/******/ })()
;
//# sourceMappingURL=blog.js.map