import ReactDOM from 'react-dom';
import React from 'react';

let components = {};

export function addComponent(string,component){
    components[string] = component;
}

const renderComponent = (string, element) => {
    // needs a capital on the first letter to render
    let Component = components[string];
    console.log(element.dataset);
    ReactDOM.render(<Component {...(element.dataset)} />, element);
}

window.ReactLoad = renderComponent;