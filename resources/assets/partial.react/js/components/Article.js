import React, { Component } from 'react';
// import ReactDOM from 'react-dom';
import PropTypes from "prop-types";


class Article extends Component {

    static propTypes = {
        title: PropTypes.string,
    }

    constructor(props) {
        super(props);

        this.state = {
            title: props.title
        }
    }

    render() {
        return (
            <li>
                { this.state.title }
            </li>
    );
}
}

export default Article;

// // We only want to try to render our component on pages that have a div with an ID
// // of "example"; otherwise, we will see an error in our console
// const loadBlog = ($element, props) => {
//     ReactDOM.render(<Article {...props} />, $element);
// }
//
// window.loadBlog = loadBlog;
