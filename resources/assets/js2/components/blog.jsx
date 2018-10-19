import React, {Component} from 'react';
import {addComponent} from "../helper";

class Blog extends Component {
    constructor(props) {
        super(props);
        console.log("props", props);
    }

    render() {
        console.log(this.props);
        return (
            <div>
                test {this.props.test}
                test2 {this.props.test2}
            </div>
        );
    }
}

export default Blog;

addComponent('Blog', Blog);