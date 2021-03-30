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
        var cloudSubs = ["Dashboard", "Clients", "Projects", "Tickets", "Tasks","UI/UX"];

        var displayPageButtons = cloudSubs.map((sub, index) =>{
            return(
                <SideNavButton key={v4()} pageName={sub}/>
            );
        });

        return displayPageButtons;

    }

    render(){
        var {cloudPage} = this.props;

        return (
            <nav className={"cloud-nav-bar content-wrap"}>
                {this.displayAppSectionsNavButtons()}
            </nav>
        );
    }
}

SideNav.propTypes = {
    cloudPage : PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    cloudPage : state.app.cloudPage,
});

export default connect(mapStateToProps , {})(SideNav);
