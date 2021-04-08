import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {submitCompanyCloudRegistration} from '../actions/cloudActions.js';

class CompanySignUpPage extends Component {
    constructor(props){
        super(props);

        this.state = {
            company_name:"",
            company_industry:"",
            company_email:"",
            company_telephone:"",
        }
    }

    componentDidMount() {
        console.log('CompanySignUpPage componentDidMount');
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {company_name,company_industry,company_email,company_telephone} = this.state;
        if(!_.isEqual(this.state, nextState)){
            return true;
        }
        return false;
    }

    submitCompanyCloudRegistration(){
        var {company_name,company_industry,company_email,company_telephone} = this.state;

        var data = {
            company_name:company_name,
            company_industry:company_industry,
            company_email:company_email,
            company_telephone:company_telephone,
        }

        this.props.submitCompanyCloudRegistration(data)
    }


    render(){
        var {company_name,company_industry,company_email,company_telephone} = this.state;

        return (
            <div className={"content-wrap wrap-start"}>
                <div className={"content"} style={{paddingTop:"20px"}}>
                    <div className={"wrap-start"}>
                        <a className={"linkBack"} onClick={()=>{this.props.toggleCloudSignUp(false)}}>Invitatons</a>
                        <p className={"linkBack"}> | Cloud Sign Up</p>
                    </div>
                    <h4 style={{marginTop:"20px",maxWidth:"800px",color:"#1770E2",fontWeight:"lighter",letterSpacing:"3px"}}>Create Your Company Cloud.</h4>
                    <p style={{fontSize:"21px",marginTop:"20px"}}>Please register your company information below to get started.</p>
                    <div className={"align-top"} style={{marginTop:"40px"}}>
                        <div className="form-input-div">
                                <label className="lrg-inpt-lbl">Company Name *</label>
                                <input id="company_name"
                                       className="main-inpt"
                                       name="company_name"
                                       type="text"
                                       autoComplete="off"
                                       required="required"
                                       autoFocus
                                       value={company_name}
                                       onChange={(event) => {this.setState({[event.target.name]:event.target.value})}}
                                />
                                <span className="invalid-feedback" role="alert"></span>
                        </div>
                        <div className="form-input-div">
                            <label className="lrg-inpt-lbl">Sector/Industry *</label>
                            <input id="company_industry"
                                   className="main-inpt"
                                   name="company_industry"
                                   type="text"
                                   autoComplete="off"
                                   required="required"
                                   autoFocus
                                   value={company_industry}
                                   onChange={(event) => {this.setState({[event.target.name]:event.target.value})}}
                            />
                            <span className="invalid-feedback" role="alert"></span>
                        </div>
                        <div className="form-input-div">
                            <label className="lrg-inpt-lbl">Company Email *</label>
                            <input id="company_email"
                                   className="main-inpt"
                                   name="company_email"
                                   type="text"
                                   autoComplete="off"
                                   required="required"
                                   autoFocus
                                   value={company_email}
                                   onChange={(event) => {this.setState({[event.target.name]:event.target.value})}}
                            />
                            <span className="invalid-feedback" role="alert"></span>
                        </div>
                        <div className="form-input-div">
                            <label className="lrg-inpt-lbl">Company Telephone *</label>
                            <input id="company_telephone"
                                   className="main-inpt"
                                   name="company_telephone"
                                   type="text"
                                   autoComplete="off"
                                   required="required"
                                   autoFocus
                                   value={company_telephone}
                                   onChange={(event) => {this.setState({[event.target.name]:event.target.value})}}
                            />
                            <span className="invalid-feedback" role="alert"></span>
                        </div>
                        <div className="form-input-div" style={{marginTop:"20px"}}>
                            <button className={"excite-act-btn"}
                                    onClick={()=>{this.submitCompanyCloudRegistration()}}
                            >Continue Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

CompanySignUpPage.propTypes = {
    navigateAppPage: PropTypes.func.isRequired,
    submitCompanyCloudRegistration: PropTypes.func.isRequired,
};

const mapStateToProps = state => ({

});

export default connect(mapStateToProps , {navigateAppPage, submitCompanyCloudRegistration})(CompanySignUpPage);
