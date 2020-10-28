import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';

class SideNavButton extends Component{
    constructor(props){
        super(props);

        this.state = {
            pageName : this.props.pageName,
        }

    }

    componentDidMount() {}

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }

    render(){
        var {pageName} = this.state;
        var {appPage} = this.props;

        return (
            <button className={"side-nav-btn"}
                    key={v4()}
            >{pageName}</button>
        );
    }
}

SideNavButton.propTypes = {
    appPage : PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    appPage : state.app.appPage,
});

export default connect(mapStateToProps , {})(SideNavButton);
