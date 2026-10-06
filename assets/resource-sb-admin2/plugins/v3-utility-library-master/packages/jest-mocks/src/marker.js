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
exports.Marker = void 0;
const mvcobject_1 = require("./mvcobject");
const index_1 = require("./index");
class Marker extends mvcobject_1.MVCObject {
    constructor(opts) {
        super();
        this.getAnimation = jest
            .fn()
            .mockImplementation(() => null);
        this.getClickable = jest.fn().mockImplementation(() => null);
        this.getCursor = jest
            .fn()
            .mockImplementation(() => null);
        this.getDraggable = jest
            .fn()
            .mockImplementation(() => null);
        this.getIcon = jest
            .fn()
            .mockImplementation(() => null);
        this.getLabel = jest
            .fn()
            .mockImplementation(() => null);
        this.getMap = jest
            .fn()
            .mockImplementation(() => null);
        this.getOpacity = jest
            .fn()
            .mockImplementation(() => null);
        this.getPosition = jest
            .fn()
            .mockImplementation(() => new index_1.LatLng({ lat: 0, lng: 0 }));
        this.getShape = jest
            .fn()
            .mockImplementation(() => null);
        this.getTitle = jest
            .fn()
            .mockImplementation(() => null);
        this.getVisible = jest.fn().mockImplementation(() => null);
        this.getZIndex = jest
            .fn()
            .mockImplementation(() => null);
        this.setAnimation = jest
            .fn()
            .mockImplementation((animation) => { });
        this.setClickable = jest.fn().mockImplementation((flag) => { });
        this.setCursor = jest.fn().mockImplementation((cursor) => { });
        this.setDraggable = jest
            .fn()
            .mockImplementation((flag) => { });
        this.setIcon = jest
            .fn()
            .mockImplementation((icon) => { });
        this.setLabel = jest
            .fn()
            .mockImplementation((label) => { });
        this.setMap = jest
            .fn()
            .mockImplementation((map) => { });
        this.setOpacity = jest
            .fn()
            .mockImplementation((opacity) => { });
        this.setOptions = jest
            .fn()
            .mockImplementation((options) => { });
        this.setPosition = jest
            .fn()
            .mockImplementation((latlng) => { });
        this.setShape = jest
            .fn()
            .mockImplementation((shape) => { });
        this.setTitle = jest.fn().mockImplementation((title) => { });
        this.setVisible = jest.fn().mockImplementation((visible) => { });
        this.setZIndex = jest.fn().mockImplementation((zIndex) => { });
        this.addListener = jest
            .fn()
            .mockImplementation((eventName, handler) => jest.fn());
    }
}
exports.Marker = Marker;
