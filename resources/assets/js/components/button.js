import * as React from "react";
import ReactDOM from 'react-dom';
import { Button } from 'antd';
import "antd/dist/antd.css";

const BLUE = "blue";
const RED = "red";
const GREEN = "green";

export default class ReactButton extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            background: props.background
        }
    }

    shouldComponentUpdate() {
        return true; // this.state.background !== RED;
    }

    onChangeColour = () => {
        const {background} = this.state;
        if (background === BLUE) {
            this.setState({background: RED});
        } else if (background === RED) {
            this.setState({background: GREEN});
        } else {
            this.setState({background: BLUE});
        }
    };

    render() {
        const {background} = this.state;
        return (
          <Button type="primary" style={{width: 100, background}} onClick={this.onChangeColour}>
              {this.props.text}
          </Button>
        );
    }
}

if (document.getElementById('foo')) {
    ReactDOM.render(React.createElement(ReactButton, {
        text: "Lorribor",
        background: GREEN
    }), document.getElementById('foo'));
}