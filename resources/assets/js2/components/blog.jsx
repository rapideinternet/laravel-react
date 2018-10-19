import React, {Component} from 'react';
import {addComponent} from "../helper";

class Blog extends Component {
    render() {
        return (
            <div>
                test 12345423423
            </div>
        );
    }
}

export default Blog;

addComponent('Blog', Blog);