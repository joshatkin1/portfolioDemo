import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import SideNavButton from '../items/buttons/SideNavButton.js';

class SideNav extends Component{
    constructor(props){
        super(props);

        this.state = {
        }

    }

    componentDidMount() {}

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {appPage} = this.props;

        if(appPage !== nextProps.appPage){
            return true;
        }
        return false;
    }

    displayAppSectionsNavButtons(){
        var pages = ["Dashboard", "Clients", "Projects", "Tickets", "Tasks","UI/UX"];

        var displayPageButtons = pages.map((page, index) =>{
            return(
                <SideNavButton key={v4()} pageName={page}/>
            );
        });

        return displayPageButtons;

    }

    render(){
        var {appPage} = this.props;

        return (
            <nav className={"content-wrap"}>
                {this.displayAppSectionsNavButtons()}
            </nav>
        );
    }
}

SideNav.propTypes = {
    appPage : PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    appPage : state.app.appPage,
});

export default connect(mapStateToProps , {})(SideNav);
