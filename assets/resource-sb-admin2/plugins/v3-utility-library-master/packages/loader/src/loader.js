"use strict";
/**
 * Copyright 2019 Google LLC. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
Object.defineProperty(exports, "__esModule", { value: true });
exports.Loader = void 0;
/// <reference types="@types/googlemaps" />
var Loader = /** @class */ (function () {
    function Loader(_a) {
        var apiKey = _a.apiKey, _b = _a.libraries, libraries = _b === void 0 ? [] : _b, channel = _a.channel, language = _a.language, clientId = _a.clientId, region = _a.region, version = _a.version;
        this.CALLBACK = "__google_maps_callback";
        this.URL = "https://maps.googleapis.com/maps/api/js";
        this.callbacks = [];
        this.done = false;
        this.loading = false;
        this.version = version;
        this.apiKey = apiKey;
        this.libraries = libraries;
        this.channel = channel;
        this.language = language;
        this.clientId = clientId;
        this.region = region;
    }
    Loader.prototype.createUrl = function () {
        var url = this.URL;
        url += "?callback=" + this.CALLBACK;
        if (this.apiKey) {
            url += "&key=" + this.apiKey;
        }
        if (this.libraries.length > 0) {
            url += "&libraries=" + this.libraries.join(",");
        }
        if (this.clientId) {
            url += "&client=" + this.clientId;
        }
        if (this.channel) {
            url += "&channel=" + this.channel;
        }
        if (this.language) {
            url += "&language=" + this.language;
        }
        if (this.region) {
            url += "&region=" + this.region;
        }
        if (this.version) {
            url += "&v=" + this.version;
        }
        return url;
    };
    Loader.prototype.load = function () {
        return this.loadPromise();
    };
    Loader.prototype.loadPromise = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            _this.loadCallback(function (err) {
                if (!err) {
                    resolve();
                }
                else {
                    reject(err);
                }
            });
        });
    };
    Loader.prototype.loadCallback = function (fn) {
        this.callbacks.push(fn);
        this.execute();
    };
    Loader.prototype.setScript = function () {
        var url = this.createUrl();
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = url;
        script.onerror = this.loadErrorCallback;
        script.defer = true;
        script.async = true;
        document.head.appendChild(script);
    };
    Loader.prototype.loadErrorCallback = function (e) {
        this.onerrorEvent = e;
        this.callback();
    };
    Loader.prototype.setCallback = function () {
        window[this.CALLBACK] = this.callback.bind(this);
    };
    Loader.prototype.callback = function () {
        var _this = this;
        this.done = true;
        this.loading = false;
        this.callbacks.forEach(function (cb) {
            cb(_this.onerrorEvent);
        });
        this.callbacks = [];
    };
    Loader.prototype.execute = function () {
        if (this.done) {
            this.callback();
        }
        else {
            if (this.loading) {
                // do nothing but wait
            }
            else {
                this.loading = true;
                this.setCallback();
                this.setScript();
            }
        }
    };
    return Loader;
}());
exports.Loader = Loader;
