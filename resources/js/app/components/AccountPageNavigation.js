import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import AccountNavBtn from "../items/buttons/AccountNavBtn.js";

class AccountPageNavigation extends Component{
    constructor(props){
        super(props);

        this.state = {}
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }

    onClick(){
        var {accountNavBarActive} = this.state;
        this.setState({accountNavBarActive:!accountNavBarActive});
    }

    render(){

        return (
            <div className={"algn-btm wrap-end"} style={{height:"100%"}}>
                <div className={"wrap-space-between"}>
                    <AccountNavBtn key={v4()} buttonPage={"profile"}/>
                    <AccountNavBtn key={v4()} buttonPage={"work"}/>
                </div>
            </div>
        );
    }
}

AccountPageNavigation.propTypes = {
};

const mapStateToProps = state => ({
});

export default connect(mapStateToProps , {})(AccountPageNavigation);
