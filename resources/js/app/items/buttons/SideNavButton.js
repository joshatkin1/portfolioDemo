import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateCloudPage} from '../../actions/appActions.js';
import {toggleClientContentPage} from '../../actions/clientActions.js';

class SideNavButton extends Component{
    constructor(props){
        super(props);

        this.state = {
            pageName : this.props.pageName,
        }

    }

    componentDidMount() {}

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {cloudPage} = this.props;
        if(cloudPage !== nextProps.cloudPage){
            return true;
        }
        return false;
    }

    returnToOriginalPageContent(){
        var {pageName} = this.props;

        switch(pageName){
            case 'Clients':this.props.toggleClientContentPage("clientSearch");break;
            default:break;
        }

        return true;
    }

    render(){
        var {pageName} = this.state;
        var {cloudPage} = this.props;

        return (
            <button key={v4()}
                    value={pageName}
                    className={cloudPage === pageName ? "side-nav-btn-actv" : "side-nav-btn"}
                    onClick={(event)=>{this.props.navigateCloudPage(event.target.value)}}
                    onDoubleClick={()=>{this.returnToOriginalPageContent()}}
            >{pageName}</button>
        );
    }
}

SideNavButton.propTypes = {
    toggleClientContentPage: PropTypes.func.isRequired,
    navigateCloudPage : PropTypes.func.isRequired,
    cloudPage : PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    cloudPage : state.app.cloudPage,
});

export default connect(mapStateToProps , {navigateCloudPage, toggleClientContentPage})(SideNavButton);
