import * as React from "react";
import ReactDOM from 'react-dom';
import { Button } from 'antd';
import "antd/dist/antd.css";

const PRIMARY = "primary";
const DASHED = "dashed";
const DANGER = "danger";

export default class ReactButton extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            type: props.type
        }
    }

    shouldComponentUpdate() {
        return true; // this.state.background !== RED;
    }

    onChangeColour = () => {
        const {type} = this.state;
        if (type === PRIMARY) {
            this.setState({type: DASHED});
        } else if (type === DASHED) {
            this.setState({type: DANGER});
        } else {
            this.setState({type: PRIMARY});
        }
    };

    render() {
        const {type} = this.state;
        return (
          <Button type={type} style={{width: 100}} onClick={this.onChangeColour}>
              {this.props.text}
          </Button>
        );
    }
}

if (document.getElementById('foo')) {
    ReactDOM.render(React.createElement(ReactButton, {
        text: "Lorribor",
        type: PRIMARY
    }), document.getElementById('foo'));
}