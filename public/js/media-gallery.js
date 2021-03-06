/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/app/MediaGallery.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    deletable: {
      type: Boolean,
      "default": false
    },
    choosable: {
      type: Boolean,
      "default": false
    },
    lazyload: {
      type: Boolean,
      "default": true
    }
  },
  data: function data() {
    return {
      photos: [],
      message: 'Loading Images...',
      query: '',
      searchResult: null,
      pane: 'gallery',
      selectedPhoto: {},
      uploadableFiles: []
    };
  },
  created: function created() {
    this.getFromServer();
  },
  updated: function updated() {
    this.enableLazyLoad();
  },
  methods: {
    doSearch: function doSearch() {
      this.getFromServer(this.query);
    },
    select: function select(photo) {
      this.pane = 'photo';
      this.selectedPhoto = photo;
    },
    choose: function choose() {
      // remove file name extensions
      var caption = this.selectedPhoto.name.replace(/\.[^/.]+$/, ""); // remove special characters with space

      caption = caption.replace(/[^\w\s]/gi, ' '); // uppercase first letter of each word

      caption = caption.toLowerCase().split(' ').map(function (s) {
        return s.charAt(0).toUpperCase() + s.substring(1);
      }).join(' ');
      var captionChosen = prompt('Enter an caption for this image', caption); //TODO we should remove any double quote in captionChosen

      this.selectedPhoto['caption'] = captionChosen;
      this.$emit('selected', this.selectedPhoto);
    },
    uploadFiles: function uploadFiles() {
      var _this = this;

      var files = document.getElementById('files').files,
          p = this;

      var _loop = function _loop(i) {
        var upf = {
          name: files[i].name,
          formdata: new FormData(),
          ajax: new XMLHttpRequest(),
          status: 'Not Started',
          completion: 0
        };
        upf.formdata.append('media', files[i]);
        upf.formdata.append('name', files[i].name); // upf.formdata.append("Content-Type", files[i].type);

        upf.ajax.upload.onprogress = function (e) {
          upf.status = 'Uploaded ' + Math.round(e.loaded / 1000) + ' KB...';
          upf.completion = Math.round(e.loaded / e.total * 100);
        };

        upf.ajax.upload.onload = function (e) {
          upf.status = 'Complete';
          upf.completion = 100;
        };

        upf.ajax.upload.onerror = function (e) {
          upf.status = 'Error uploading the file';
          upf.completion = 0;
        }; // ajax.upload.addEventListener('abort', abortHandler, false);


        upf.ajax.open('POST', '/admin/media');
        upf.ajax.setRequestHeader("X-CSRF-Token", document.head.querySelector('meta[name="csrf-token"]').content);

        upf.ajax.onreadystatechange = function () {
          if (upf.ajax.readyState === 4 && upf.ajax.status === 201) {
            var photo = JSON.parse(upf.ajax.responseText);
            p.photos.push(photo);
          }

          if (upf.ajax.readyState === 4 && upf.ajax.status != 201) {
            upf.status = 'Error uploading the file (Status = ' + upf.ajax.status + ')';
            upf.completion = 0;
          }
        };

        upf.ajax.send(upf.formdata);

        _this.uploadableFiles.push(upf);
      };

      for (var i = 0; i < files.length; i++) {
        _loop(i);
      }
    },
    // Gets media data from the server. If a query string is 
    // provided then only returns the data that fulfill
    // the search conditions in query string.
    getFromServer: function getFromServer(query, callback) {
      var p = this;
      var url = '/api/media' + (typeof query != 'undefined' && query != null ? '?query=' + encodeURIComponent(query) : '');
      axios.get(url).then(function (response) {
        p.photos = response.data.data;
        p.message = null;
        p.searchResult = response.data.total + ' image(s)';
        if (typeof callback != 'undefined') callback.call();
      })["catch"](function (error) {
        p.message = 'Request failed with ' + error.response.status + ': ' + error.response.statusText;

        if (error.response.status == '403') {
          // special helpful message for loggedout situations
          p.message += '. Make sure you are logged in or refresh the page.';
        }
      });
    },
    destroy: function destroy(id) {
      if (confirm("Are you sure that you want to delete this? \nThis will permanently delete this media. This action is unrecoverable.")) {
        var p = this;
        axios["delete"]('/admin/media/' + id).then(function (response) {
          flash({
            message: response.data.flash.message
          });
          var id = response.data.photo_id,
              l = p.photos.length;

          for (var i = 0; i < l; i++) {
            if (p.photos[i].id === id) {
              p.photos.splice(i, 1);
              break;
            }
          }

          p.pane = 'gallery';
        });
      }
    },
    // This is an experimental function that enables
    // lazy-loading. This can be toggled via the
    // optional "lazyloading" attribute
    enableLazyLoad: function enableLazyLoad() {
      var images = document.querySelectorAll('.mg-photo');
      var config = {
        root: document.querySelector('.thumbnail-container'),
        // If the image gets within 100px in the Y axis, start the download.
        rootMargin: '0px 0px 50px 0px'
      }; // check if intersection observer is supported via browser

      if (!('IntersectionObserver' in window) || this.lazyload === false) {
        // if not, just load all immediately
        Array.from(images).forEach(function (image) {
          console.log('IntersectionObserver unsupported loading');
          if (!image.src) image.src = image.dataset.src;
        });
      } else {
        // The observer is supported
        var observer = new IntersectionObserver(function (entries) {
          // Loop through the entries
          entries.forEach(function (image) {
            // Are we in viewport?
            if (image.isIntersecting) {
              // Stop watching and load the image
              //console.log('Loading: ' + image.target.dataset.src)
              observer.unobserve(image.target);
              image.target.src = image.target.dataset.src;
            }
          });
        }, config); // start observing...

        images.forEach(function (image) {
          observer.observe(image);
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".thumbnail-container {\n  max-height: 450px;\n}\n.thumbnail {\n  height: 100px;\n  overflow: hidden;\n}\n.postcard-container {\n  max-height: 450px;\n}\n.postcard {\n  max-height: 400px;\n  overflow: scroll;\n}\n.mg-photo {\n  width: 100%;\n  height: 100%;\n  -o-object-fit: cover;\n     object-fit: cover;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/lib/css-base.js":
/*!*************************************************!*\
  !*** ./node_modules/css-loader/lib/css-base.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./MediaGallery.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/lib/addStyles.js":
/*!****************************************************!*\
  !*** ./node_modules/style-loader/lib/addStyles.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getTarget = function (target, parent) {
  if (parent){
    return parent.querySelector(target);
  }
  return document.querySelector(target);
};

var getElement = (function (fn) {
	var memo = {};

	return function(target, parent) {
                // If passing function in options, then use it for resolve "head" element.
                // Useful for Shadow Root style i.e
                // {
                //   insertInto: function () { return document.querySelector("#foo").shadowRoot }
                // }
                if (typeof target === 'function') {
                        return target();
                }
                if (typeof memo[target] === "undefined") {
			var styleTarget = getTarget.call(this, target, parent);
			// Special case to return head of iframe instead of iframe itself
			if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
				try {
					// This will throw an exception if access to iframe is blocked
					// due to cross-origin restrictions
					styleTarget = styleTarget.contentDocument.head;
				} catch(e) {
					styleTarget = null;
				}
			}
			memo[target] = styleTarget;
		}
		return memo[target]
	};
})();

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(/*! ./urls */ "./node_modules/style-loader/lib/urls.js");

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton && typeof options.singleton !== "boolean") options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
        if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else if (typeof options.insertAt === "object" && options.insertAt.before) {
		var nextSibling = getElement(options.insertAt.before, target);
		target.insertBefore(style, nextSibling);
	} else {
		throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	if(options.attrs.type === undefined) {
		options.attrs.type = "text/css";
	}

	if(options.attrs.nonce === undefined) {
		var nonce = getNonce();
		if (nonce) {
			options.attrs.nonce = nonce;
		}
	}

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	if(options.attrs.type === undefined) {
		options.attrs.type = "text/css";
	}
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function getNonce() {
	if (false) {}

	return __webpack_require__.nc;
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = typeof options.transform === 'function'
		 ? options.transform(obj.css) 
		 : options.transform.default(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ }),

/***/ "./node_modules/style-loader/lib/urls.js":
/*!***********************************************!*\
  !*** ./node_modules/style-loader/lib/urls.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
  // get current location
  var location = typeof window !== "undefined" && window.location;

  if (!location) {
    throw new Error("fixUrls requires window.location");
  }

	// blank or null?
	if (!css || typeof css !== "string") {
	  return css;
  }

  var baseUrl = location.protocol + "//" + location.host;
  var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
	This regular expression is just a way to recursively match brackets within
	a string.

	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
	   (  = Start a capturing group
	     (?:  = Start a non-capturing group
	         [^)(]  = Match anything that isn't a parentheses
	         |  = OR
	         \(  = Match a start parentheses
	             (?:  = Start another non-capturing groups
	                 [^)(]+  = Match anything that isn't a parentheses
	                 |  = OR
	                 \(  = Match a start parentheses
	                     [^)(]*  = Match anything that isn't a parentheses
	                 \)  = Match a end parentheses
	             )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
	 \)  = Match a close parens

	 /gi  = Get all matches, not the first.  Be case insensitive.
	 */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl
			.trim()
			.replace(/^"(.*)"$/, function(o, $1){ return $1; })
			.replace(/^'(.*)'$/, function(o, $1){ return $1; });

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(unquotedOrigUrl)) {
		  return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
		  	//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "w-full" }, [
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.pane === "gallery",
            expression: "pane==='gallery'"
          }
        ],
        staticClass:
          "w-full mx-auto py-4 px-4 bg-grey-lighter flex flex-no-wrap"
      },
      [
        _c("div", { staticClass: "flex w-full" }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.query,
                expression: "query"
              }
            ],
            staticClass:
              "p-2 w-full rounded-l-lg rounded-r-lg sm:rounded-r-none border-l border-r sm:border-r-0 border-t border-b border-blue-lighter bg-white",
            attrs: { type: "text", placeholder: "search..." },
            domProps: { value: _vm.query },
            on: {
              keyup: function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                ) {
                  return null
                }
                return _vm.doSearch($event)
              },
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.query = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "hidden sm:flex relative pin-r rounded-r-lg border-r border-t border-b border-blue-lighter bg-white py-1 px-2  items-center"
            },
            [
              _vm.searchResult
                ? _c("span", {
                    staticClass:
                      "py-1 px-2 bg-grey-lighter rounded-lg text-xs whitespace-no-wrap",
                    domProps: { textContent: _vm._s(_vm.searchResult) }
                  })
                : _vm._e()
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "mx-2",
            attrs: { title: "Upload Image" },
            on: {
              click: function($event) {
                _vm.pane = "upload"
              }
            }
          },
          [
            _c(
              "svg",
              {
                staticClass:
                  "h-10 w-8 text-blue-dark fill-current hover:bg-blue-lightest hover:text-blue",
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  viewBox: "0 0 20 20"
                }
              },
              [
                _c("path", {
                  attrs: {
                    d:
                      "M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"
                  }
                })
              ]
            )
          ]
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.pane === "gallery",
            expression: "pane==='gallery'"
          }
        ],
        staticClass:
          "w-full flex flex-wrap px-4 thumbnail-container overflow-y-scroll"
      },
      _vm._l(_vm.photos, function(photo) {
        return _c(
          "div",
          { key: photo.id, staticClass: "w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5" },
          [
            _c(
              "div",
              {
                staticClass: "bg-white shadow mr-4 mb-4 cursor-pointer",
                on: {
                  click: function($event) {
                    return _vm.select(photo)
                  }
                }
              },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "w-full flex items-center justify-center thumbnail"
                  },
                  [
                    _c("img", {
                      staticClass: "mg-photo",
                      attrs: { "data-src": photo.url }
                    })
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "w-full flex bg-white justify-between text-grey-dark text-xs p-2"
                  },
                  [
                    _c("span", {
                      domProps: {
                        textContent: _vm._s(photo.storage.toUpperCase())
                      }
                    }),
                    _vm._v(" "),
                    _c("span", [_vm._v(_vm._s(photo.size) + " KB")])
                  ]
                )
              ]
            )
          ]
        )
      }),
      0
    ),
    _vm._v(" "),
    _vm.pane === "photo"
      ? _c(
          "div",
          {
            staticClass:
              "w-full mx-auto py-4 px-4 bg-grey-lighter flex justify-between items-center"
          },
          [
            _c(
              "button",
              {
                staticClass: "flex items-center",
                on: {
                  click: function($event) {
                    _vm.pane = "gallery"
                  }
                }
              },
              [
                _c(
                  "svg",
                  {
                    staticClass:
                      "fill-current h-8 w-8 rounded-full border p-2 text-grey-dark mr-2",
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      viewBox: "0 0 20 20"
                    }
                  },
                  [
                    _c("polygon", {
                      attrs: {
                        points:
                          "3.828 9 9.899 2.929 8.485 1.515 0 10 .707 10.707 8.485 18.485 9.899 17.071 3.828 11 20 11 20 9 3.828 9"
                      }
                    })
                  ]
                ),
                _vm._v(" "),
                _c("p", {
                  staticClass: "text-blue-darker text-xl",
                  domProps: { textContent: _vm._s(_vm.selectedPhoto.name) }
                })
              ]
            ),
            _vm._v(" "),
            _vm.deletable
              ? _c(
                  "span",
                  {
                    staticClass:
                      "text-red mr-4 px-2 text-sm py-1 hover:border border-red hover:text-white hover:bg-red rounded cursor-pointer",
                    on: {
                      click: function($event) {
                        return _vm.destroy(_vm.selectedPhoto.id)
                      }
                    }
                  },
                  [_vm._v("Delete ")]
                )
              : _vm._e()
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.pane === "photo"
      ? _c(
          "div",
          {
            staticClass:
              "w-full flex justify-center items-center px-4 postcard-container overflow-y-scroll"
          },
          [
            _c(
              "div",
              { staticClass: "w-full bg-white shadow mr-4 mb-4 xl:flex" },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "w-full xl:w-4/5 flex items-center justify-center postcard"
                  },
                  [
                    _c("img", {
                      staticClass: "mg-photo border-2 border-blue-lightest",
                      attrs: { src: _vm.selectedPhoto.url }
                    })
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "w-full xl:w-1/5 text-xs px-2 py-2 flex flex-no-wrap xl:flex-wrap xl:content-between justify-between items-center",
                    staticStyle: { "background-color": "aliceblue" }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass:
                          "xl:w-full flex xl:flex-wrap justify-start content-start"
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "w-full m-2 hidden sm:block" },
                          [
                            _c(
                              "p",
                              { staticClass: "text-grey-dark uppercase" },
                              [_vm._v("Name")]
                            ),
                            _vm._v(" "),
                            _c("p", {
                              staticClass: "text-blue-darker",
                              domProps: {
                                textContent: _vm._s(_vm.selectedPhoto.name)
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "w-full m-2 hidden md:block" },
                          [
                            _c(
                              "p",
                              { staticClass: "text-grey-dark uppercase" },
                              [_vm._v("Type")]
                            ),
                            _vm._v(" "),
                            _c("p", {
                              staticClass: "text-blue-darker",
                              domProps: {
                                textContent: _vm._s(
                                  _vm.selectedPhoto.type.toUpperCase()
                                )
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "w-full m-2" }, [
                          _c("p", { staticClass: "text-grey-dark uppercase" }, [
                            _vm._v("Size")
                          ]),
                          _vm._v(" "),
                          _c("p", { staticClass: "text-blue-darker" }, [
                            _vm._v(_vm._s(_vm.selectedPhoto.size) + " KB")
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "w-full m-2 hidden lg:block" },
                          [
                            _c(
                              "p",
                              { staticClass: "text-grey-dark uppercase" },
                              [_vm._v("Storage")]
                            ),
                            _vm._v(" "),
                            _c("p", {
                              staticClass: "text-blue-darker",
                              domProps: {
                                textContent: _vm._s(
                                  _vm.selectedPhoto.storage.toUpperCase()
                                )
                              }
                            })
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _vm.choosable
                      ? _c(
                          "button",
                          {
                            staticClass:
                              "h-10 xl:mx-auto mb-2 xl:w-full1 py-2 px-6 bg-green text-white rounded shadow text-xl",
                            on: { click: _vm.choose }
                          },
                          [_vm._v("Choose")]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.pane === "upload"
      ? _c(
          "div",
          { staticClass: "w-full p-4 postcard-container overflow-y-scroll" },
          [
            _c("div", { staticClass: "flex justify-between" }, [
              _c(
                "button",
                {
                  staticClass: "flex items-center",
                  on: {
                    click: function($event) {
                      _vm.pane = "gallery"
                    }
                  }
                },
                [
                  _c(
                    "svg",
                    {
                      staticClass:
                        "fill-current h-8 w-8 rounded-full border p-2 text-grey-dark mr-2",
                      attrs: {
                        xmlns: "http://www.w3.org/2000/svg",
                        viewBox: "0 0 20 20"
                      }
                    },
                    [
                      _c("polygon", {
                        attrs: {
                          points:
                            "3.828 9 9.899 2.929 8.485 1.515 0 10 .707 10.707 8.485 18.485 9.899 17.071 3.828 11 20 11 20 9 3.828 9"
                        }
                      })
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "p",
                    {
                      staticClass:
                        "text-grey-dark font-light text-lg hidden sm:block"
                    },
                    [_vm._v("Back to Gallery")]
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "form",
                {
                  attrs: {
                    id: "file-catcher",
                    enctype: "multipart/form-data",
                    method: "post"
                  }
                },
                [
                  _c("div", { staticClass: "w-full flex bg-grey-lighter" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "flex items-center px-4 py-2 rounded-lg border border-blue bg-white text-blue tracking-wide cursor-pointer hover:bg-blue hover:text-white"
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "w-8 h-8 mr-4",
                            attrs: {
                              fill: "currentColor",
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 20 20"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm._m(0),
                        _vm._v(" "),
                        _c("input", {
                          staticClass: "hidden",
                          attrs: {
                            id: "files",
                            type: "file",
                            name: "files",
                            multiple: ""
                          },
                          on: { change: _vm.uploadFiles }
                        })
                      ]
                    )
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _vm.uploadableFiles.length > 0
              ? _c(
                  "div",
                  {
                    staticClass: "w-full my-4",
                    attrs: { id: "file-list-display" }
                  },
                  [
                    _c("table", { staticClass: "w-full my-2 text-sm" }, [
                      _vm._m(1),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.uploadableFiles, function(f, index) {
                          return _c(
                            "tr",
                            { key: index, staticClass: "p-2 border-b" },
                            [
                              _c("td", {
                                staticClass: "text-left p-2 hidden md:block",
                                domProps: { textContent: _vm._s(index + 1) }
                              }),
                              _vm._v(" "),
                              _c("td", {
                                staticClass: "text-left p-2",
                                domProps: { textContent: _vm._s(f.name) }
                              }),
                              _vm._v(" "),
                              _c("td", [
                                _c("span", {
                                  domProps: { textContent: _vm._s(f.status) }
                                })
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c("progress", {
                                  staticClass: "my-2 w-full",
                                  attrs: { id: "progressBar", max: "100" },
                                  domProps: { value: f.completion }
                                })
                              ])
                            ]
                          )
                        }),
                        0
                      )
                    ])
                  ]
                )
              : _vm._e()
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.message
      ? _c(
          "div",
          {
            staticClass: "p-2 bg-white w-full text-sm text-grey-dark rounded",
            attrs: { id: "message" }
          },
          [_c("span", { domProps: { textContent: _vm._s(_vm.message) } })]
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "text-base leading-normal " }, [
      _vm._v("Upload "),
      _c("span", { staticClass: "hidden sm:inline" }, [_vm._v("Media Files")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "bg-white text-left" }, [
        _c("th", { staticClass: "p-2 font-light hidden md:block" }, [
          _vm._v("#")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 font-light" }, [_vm._v("File Name")]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 font-light" }, [_vm._v("Status")]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 font-light" }, [_vm._v("Progress")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/app/MediaGallery.vue":
/*!*******************************************!*\
  !*** ./resources/js/app/MediaGallery.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MediaGallery.vue?vue&type=template&id=1843069a& */ "./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a&");
/* harmony import */ var _MediaGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MediaGallery.vue?vue&type=script&lang=js& */ "./resources/js/app/MediaGallery.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MediaGallery.vue?vue&type=style&index=0&lang=css& */ "./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MediaGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/app/MediaGallery.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/app/MediaGallery.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/app/MediaGallery.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./MediaGallery.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************!*\
  !*** ./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./MediaGallery.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a&":
/*!**************************************************************************!*\
  !*** ./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./MediaGallery.vue?vue&type=template&id=1843069a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/app/MediaGallery.vue?vue&type=template&id=1843069a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaGallery_vue_vue_type_template_id_1843069a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/media-gallery.js":
/*!***************************************!*\
  !*** ./resources/js/media-gallery.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// add the Vue file for the media gallery application
Vue.component('media-gallery', __webpack_require__(/*! ./app/MediaGallery.vue */ "./resources/js/app/MediaGallery.vue").default);

/***/ }),

/***/ 3:
/*!*********************************************!*\
  !*** multi ./resources/js/media-gallery.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/akash/code/flower/resources/js/media-gallery.js */"./resources/js/media-gallery.js");


/***/ })

/******/ });