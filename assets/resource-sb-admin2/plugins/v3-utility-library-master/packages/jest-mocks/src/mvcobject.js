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
exports.MVCObject = void 0;
/* eslint-disable @typescript-eslint/no-explicit-any */
class MVCObject {
    constructor() {
        this.addListener = jest
            .fn()
            .mockImplementation((eventName, handler) => { });
        this.bindTo = jest
            .fn()
            .mockImplementation((key, target, targetKey, noNotify) => { });
        this.changed = jest.fn().mockImplementation((key) => { });
        this.get = jest.fn().mockImplementation((key) => { });
        this.notify = jest.fn().mockImplementation((key) => { });
        this.set = jest.fn().mockImplementation((key, value) => { });
        this.setValues = jest.fn().mockImplementation((values) => { });
        this.unbind = jest.fn().mockImplementation((key) => { });
        this.unbindAll = jest.fn().mockImplementation(() => { });
    }
}
exports.MVCObject = MVCObject;
