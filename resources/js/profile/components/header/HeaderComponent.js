import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import AppNavButtons from './AppNavButtons.js';

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
        var {workCloudPage} = this.props;
        return (
            <header className={"header-bar container-row wrap-middle algn-cntr"}>
                <div className={"col-6 wrap-start algn-cntr"}
                     style={{height:"50px"}}
                     onDoubleClick={()=>{window.location.href = "/profile";}}
                >
                    <a href={'/profile'}>
                        <h4 className="webtitle">workcloud</h4>
                    </a>
                </div>
                <div className={"col-6 wrap-end algn-cntr"}>
                    <AppNavButtons key={v4()}/>
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
