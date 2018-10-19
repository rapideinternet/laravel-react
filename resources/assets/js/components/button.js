//import libs
import React, {Component} from 'react'
import PropTypes from 'prop-types'

class Button extends Component {
    static displayName = 'Button'
    static propTypes = {
        isAuthenticated: PropTypes.bool.isRequired,
        user: PropTypes.object.isRequired,
        children: PropTypes.node.isRequired,
        dispatch: PropTypes.func.isRequired,
    }

    constructor(props) {
        super(props)

        this.state = {
            //
        }
    }

    render() {
        return <Button>
            {this.props.children}
        </Button>
    }
}

export default Button;
