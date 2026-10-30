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
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
/// <reference types="@types/jest" />
/* eslint-disable @typescript-eslint/no-explicit-any */
const loader_1 = require("./loader");
test.each([
    [
        {},
        "https://maps.googleapis.com/maps/api/js?callback=__google_maps_callback"
    ],
    [
        { apiKey: "foo" },
        "https://maps.googleapis.com/maps/api/js?callback=__google_maps_callback&key=foo"
    ],
    [
        {
            apiKey: "foo",
            version: "weekly",
            libraries: ["places"],
            clientId: "bar",
            channel: "channel",
            language: "language",
            region: "region"
        },
        "https://maps.googleapis.com/maps/api/js?callback=__google_maps_callback&key=foo&libraries=places&client=bar&channel=channel&language=language&region=region&v=weekly"
    ]
])("createUrl is correct", (options, expected) => {
    const loader = new loader_1.Loader(options);
    expect(loader.createUrl()).toEqual(expected);
});
test("setScript adds a script to head with correct attributes", () => {
    const loader = new loader_1.Loader({ apiKey: "" });
    loader["setScript"]();
    const script = document.head.childNodes[0];
    expect(script.src).toEqual(loader.createUrl());
    expect(script.defer).toBeTruthy();
    expect(script.async).toBeTruthy();
    expect(script.onerror).toEqual(loader["loadErrorCallback"]);
    expect(script.type).toEqual("text/javascript");
});
test("load should return a promise that resolves even if called twice", () => {
    const loader = new loader_1.Loader({ apiKey: "" });
    expect.assertions(1);
    const promise = Promise.all([loader.load(), loader.load()]).then(() => {
        expect(loader["done"]).toBeTruthy();
    });
    window[loader["CALLBACK"]]();
    return promise;
});
test("loadCallaback callback", () => {
    const loader = new loader_1.Loader({ apiKey: "" });
    expect.assertions(2);
    loader.loadCallback((e) => {
        expect(loader["done"]).toBeTruthy();
        expect(e).toBeUndefined();
    });
    window[loader["CALLBACK"]]();
});
test("script onerror should reject promise", () => {
    const loader = new loader_1.Loader({ apiKey: "" });
    expect.assertions(3);
    const promise = loader.load().catch(e => {
        expect(e).toBeTruthy();
        expect(loader["done"]).toBeTruthy();
        expect(loader["loading"]).toBeFalsy();
    });
    loader["loadErrorCallback"](document.createEvent("ErrorEvent"));
    return promise;
});
test("loader should resolve immediately when successfully loaded", () => __awaiter(void 0, void 0, void 0, function* () {
    // use await/async pattern since the promise resolves without trigger
    const loader = new loader_1.Loader({ apiKey: "" });
    loader["done"] = true;
    yield expect(loader.loadPromise()).resolves.toBeUndefined();
}));
test("loader should resolve immediately when failed loading", () => __awaiter(void 0, void 0, void 0, function* () {
    // use await/async pattern since the promise rejects without trigger
    const loader = new loader_1.Loader({ apiKey: "" });
    loader["done"] = true;
    loader["onerrorEvent"] = document.createEvent("ErrorEvent");
    yield expect(loader.loadPromise()).rejects.toBeDefined();
}));
test("loader should wait if already loading", () => {
    const loader = new loader_1.Loader({ apiKey: "" });
    loader["loading"] = true;
    loader.load();
});
