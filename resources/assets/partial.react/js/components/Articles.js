import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from "prop-types";
import Article from "./Article";


class Articles extends Component {

    static propTypes = {
        articles: PropTypes.array,
    }

    constructor(props) {
        super(props);
        console.log(props.articles);

        this.state = {
            articles: props.articles
        }
    }

    render() {
        return (
            <div>
                <ul>
                    {this.state.articles.map((article, index) => {
                        return (
                            <Article key={index} title={article.title}/>
                        );
                    })}
                </ul>
            </div>
    );
}
}

export default Articles;

// We only want to try to render our component on pages that have a div with an ID
// of "example"; otherwise, we will see an error in our console
const loadBlog = ($element, props) => {
    ReactDOM.render(<Articles {...props} />, $element);
}

window.loadBlog = loadBlog;
