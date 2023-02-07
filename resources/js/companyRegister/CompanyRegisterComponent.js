import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import HeaderComponent from "./component/HeaderComponent.js";

class CompanyRegisterComponent extends Component{
    constructor(props){
        super(props);

        this.state = {
            formStep: 1,
            company_name: "",
            company_name_error: false,
            company_industry: "",
            company_industry_error: false,
            company_tel: "",
            company_email: "",
            company_email_error: false,
        }
    }

    componentDidMount() {
        console.log('CompanyRegisterComponent componentDidMount');
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        if(! _.isEqual(this.state , nextState)
        || formStep !== nextState.formStep){
            return true;
        }
        return false;
    }

    submitCompanyRegisterForm(){
        var {formStep, company_name, company_name_error, company_industry, company_industry_error,company_tel, company_email, company_email_error} = this.state;
        var formError = false;

        if(company_name === ""){
            this.setState({company_name_error : true});
            formError = true;
        }
        if(company_industry === ""){
            this.setState({company_industry_error : true});
            formError = true;
        }
        if(company_email_error === ""){
            this.setState({company_email_error : true});
            formError = true;
        }
        if(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/.test(company_email)){}else{
            this.setState({company_email_error : true});
            formError = true;
        }

        if(formError === false){
            var data = {
                company_name: company_name,
                company_industry: company_industry,
                company_email: company_email,
                company_tel: company_tel
            }
            axios.post('/company/register/submit', data)
                .then(
                    this.setState({
                        formStep : 2,
                        company_name: "",
                        company_name_error: false,
                        company_industry: "",
                        company_industry_error: false,
                        company_tel: "",
                        company_email: "",
                        company_email_error: false,
                    })
                )
                .catch( errors => {
                    console.log(errors);
                })
        }
    }

    render(){
        var {formStep, company_name, company_name_error, company_industry, company_industry_error, company_tel, company_email, company_email_error} = this.state;

        return (
            <div className={"content-wrap algn-cntr"}>
                <div className={"content-wrap algn-cntr"}>
                    <HeaderComponent key={v4()}/>
                </div>
                {formStep === 1 ?
                        <div className={"body-content-wrap container wrap-start"}>
                            <h3 className={"cmpreghd"}>Create a free company cloud account.</h3>
                            <p style={{fontSize:"23px",lineHeight:"1.4"}}>Subscribe to portfolioDemo and drive your business further <br/> with better management, control & collaboration.</p>
                            <div id={"comp-reg-form"}>
                                <p style={{fontSize:"25px", color:"#1770E2"}}>Company Details</p>
                                <div className={"regcmpinptdiv"}>
                                    <label className={"lrg-inpt-lbl"}>Company Name*</label>
                                    <input value={company_name} onChange={(event) => {this.setState({[event.target.name] : event.target.value})}} id="company_name" className={"lrg-inpt compdetailsinpt hide-comp-typ-opts"} name={"company_name"} type="text" autoComplete="off" required="required" autoFocus/>
                                    {company_name_error ?
                                        <span><p className={"invalid-feedback"}>required</p></span>
                                        :
                                        <></>
                                    }
                                </div>
                                <div className={"regcmpinptdiv"}>
                                    <label className={"lrg-inpt-lbl"}>Industry*</label>
                                    <input value={company_industry} onChange={(event) => {this.setState({[event.target.name] : event.target.value})}} id="company_industry" className={"lrg-inpt compdetailsinpt"} name={"company_industry"} type="text" autoComplete="off" required="required" />
                                    {company_industry_error ?
                                        <span><p className={"invalid-feedback"}>required</p></span>
                                        :
                                        <></>
                                    }
                                </div>
                                <div className={"regcmpinptdiv"}>
                                    <label className={"lrg-inpt-lbl"}>Company Telephone</label>
                                    <input value={company_tel} onChange={(event) => {this.setState({[event.target.name] : event.target.value})}} id="company_tel" className={"lrg-inpt compdetailsinpt hide-comp-typ-opts"} name={"company_tel"} type="text" autoComplete="off" required="required" />
                                </div>
                                <div className={"regcmpinptdiv"}>
                                    <label className={"lrg-inpt-lbl"}>Company Email*</label>
                                    <input value={company_email} onChange={(event) => {this.setState({[event.target.name] : event.target.value})}} id="company_email" className={"lrg-inpt compdetailsinpt hide-comp-typ-opts"} name={"company_email"} type="text" autoComplete="off" required="required" />
                                    {company_email_error ?
                                        <span><p className={"invalid-feedback"}>valid email address required</p></span>
                                        :
                                        <></>
                                    }
                                </div>
                                <div className="regcmpinptdiv" style={{marginTop:"25px"}}>
                                    <button onClick={() => {this.submitCompanyRegisterForm()}} className={"lrg-btn blubtn"} type={"submit"} style={{padding:"15px 0px", borderRadius:"20px"}}>Create Company Cloud</button>
                                </div>
                            </div>
                        </div>
                    :
                    <div className={"body-content-wrap container wrap-start"}>
                        <h3 className={"cmpreghd"} style={{marginTop:"100px"}}>Welcome, your cloud account is ready to use !</h3>
                        <p style={{fontSize:"23px",lineHeight:"1.4"}}>Please continue with the free account or upgrade for unlimited storage and additional users.</p>
                        <br/><br/><br/><br/><br/>
                        <div>
                            <a href={"/cloud"}><button className={"whitebtn lrg-btn"} style={{padding:"20px", borderRadius:"20px"}}>Continue with Free Account</button></a>
                            <br/>
                            <button className={"blubtn lrg-btn"} style={{padding:"20px", marginTop:"20px", borderRadius:"20px"}}>Upgrade to Premium Cloud</button>
                        </div>
                    </div>
                }
            </div>
        );
    }
}

CompanyRegisterComponent.propTypes = {
};

const mapStateToProps = state => ({
});

export default connect(mapStateToProps , {})(CompanyRegisterComponent);
