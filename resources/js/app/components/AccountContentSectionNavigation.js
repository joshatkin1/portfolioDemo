import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAccountPageSection} from '../actions/accountActions.js';

class AccountContentSectionNavigation extends Component{
    constructor(props){
        super(props);

        this.state = {
            contentSections: [],
        }
    }

    componentDidMount() {
        var {accountPage} = this.props;

        switch(accountPage){
            case 'profile': this.setState({contentSections: ["about", "cv"]});break;
            case 'work': this.setState({contentSections: ["preferences", "work", "applications"]});break;
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {contentSections} = this.state;
        var {accountPage, accountPageSection} = this.props;
        if(accountPage !== nextProps.accountPage
        || contentSections !== nextState.contentSections
        || accountPageSection !== nextProps.accountPageSection){
            return true;
        }
        return false;
    }

    onClick(event){
        this.props.navigateAccountPageSection(event.target.value);
    }

    displayAccountPageSectionNavButtons(){
        var {contentSections} = this.state;
        var {accountPageSection} = this.props;

        var displayButtons = contentSections.map((sec) => {
            return (
                <button className={accountPageSection === sec ? "acnt-nav-btns actv-nav-btn" : "acnt-nav-btns"}
                        onClick={(event) =>{this.onClick(event)}}
                        value={sec}
                        key={v4()}
                >{sec}</button>
            );
        });

        return displayButtons;
    }

    render(){

        return (
                <>
                    {this.displayAccountPageSectionNavButtons()}
                </>
        );
    }
}

AccountContentSectionNavigation.propTypes = {
    navigateAccountPageSection: PropTypes.func.isRequired,
    accountPageSection: PropTypes.string.isRequired,
    accountPage: PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    accountPageSection: state.account.accountPageSection,
    accountPage: state.account.accountPage,
});

export default connect(mapStateToProps , {navigateAccountPageSection})(AccountContentSectionNavigation);
