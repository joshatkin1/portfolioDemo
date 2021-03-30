import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';

class NavComponent extends Component{
    constructor(props){
        super(props);

        this.state = {
        }

    }

    componentDidMount() {

    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {userAuthenticated} = this.state;
        var {sessionData} = this.props;

        if(userAuthenticated !== nextState.userAuthenticated ||
            sessionData !== nextProps.sessionData
        ){
            return true;
        }
        return false;
    }

    render(){
        var {sessionData} = this.props;

        return (
            <nav className={"nav-bar container-wrap wrap-end algn-cntr"}>
                <div className={"content-padding wrap-end algn-cntr"}>
                    {
                        sessionData.loggedIn === true ?
                            <p>user is authenticated</p>
                            :
                            <p>user is not authenticated</p>
                    }
                </div>
            </nav>
        );
    }
}

NavComponent.propTypes = {
    sessionData: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
});

export default connect(mapStateToProps , {})(NavComponent);
