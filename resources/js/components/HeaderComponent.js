import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import SyncSoftLogo from '../../../public/images/syncsoft.svg';
import AccountButton from '../components/AccountButton.js';

class HeaderComponent extends Component{
    constructor(props){
        super(props);

        this.state = {

        }
    }

    componentDidMount() {}

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }

    render(){
        return (
            <header className={"header-bar container-row wrap-middle algn-cntr"}>
                    <div className={"col-3 wrap-start algn-cntr"}>
                       <img src={SyncSoftLogo} alt="syncsoft" style={{marginLeft:"20px",marginTop:"-10px"}} />
                    </div>
                    <div className={"col-9 wrap-end algn-cntr"}>
                        <AccountButton key={v4()} />
                    </div>
            </header>
        );
    }
}

HeaderComponent.propTypes = {
};

const mapStateToProps = state => ({
});

export default connect(mapStateToProps , {})(HeaderComponent);
