import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {getUsersCompanyCloudInvitations} from '../actions/userActions.js';

class PendingCloudPage extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('CompanySignUpPage componentDidMount');
        this.props.getUsersCompanyCloudInvitations();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {cloudInvitations} = this.props;
        if(cloudInvitations !== nextProps.cloudInvitations){
            return true;
        }
        return false;
    }

    displayPendingCompanyCloudInvitations(){
        var {cloudInvitations} = this.props;

        var invitationDisplay = cloudInvitations.map((inv)=>{
            return(
                <tr key={v4()}>
                    <td>{inv.company.company_name}</td>
                    <td>{inv.invited_by}</td>
                    <td>{inv.created_at}</td>
                    <td><button className={"blubtn cld-invt-btns"}
                                onClick={(event) => {this.acceptCompanyCloudInvite(event)}}
                    >Accept</button></td>
                    <td><button className={"redbtn cld-invt-btns"}
                                invitation_id={inv.id}
                                invitation_key={inv.invitation_key}
                                onClick={(event) => {this.declineCompanyCloudInvite(event)}}
                    >Decline</button></td>
                </tr>
            );
        });

        return invitationDisplay;
    }

    declineCompanyCloudInvite(event){
        var inv_id = event.target.getAttribute("invitation_id");
        var inv_key = event.target.getAttribute("invitation_key");

    }

    acceptCompanyCloudInvite(event){
        var inv_id = event.target.getAttribute("invitation_id");
        var inv_key = event.target.getAttribute("invitation_key");
    }

    render(){
        return (
            <div className={"content-wrap wrap-start"}>
                <div className={"content"}>
                    <h4 style={{marginTop:"40px",maxWidth:"800px",color:"#1770E2", fontWeight:"600",lineHeight:"1.4",letterSpacing:"3px"}}>You are not yet connected to a company cloud.</h4>
                    <p style={{fontSize:"21px",marginTop:"25px"}}>Please get started by creating a company cloud below or accepting an invitation.</p>
                    <p style={{marginTop:"20px",fontWeight:"lighter"}}>Your account can only be attached to one company cloud at any one time. Dont create a cloud if your awaiting an invitation. </p>
                    <p style={{fontSize:"11px",marginTop:"20px",marginBottom:"10px",fontWeight:"lighter"}}>pending invitations below</p>
                    <div style={{width:"600px", height:"150px", overflowY:"scroll"}}>
                        <table>
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>From</th>
                                    <th>Invitation Sent</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {this.displayPendingCompanyCloudInvitations()}
                            </tbody>
                        </table>
                    </div>
                    <button className={"excite-act-btn"} style={{marginTop:"40px"}}>Create Your Cloud</button>
                </div>
            </div>
        );
    }
}

PendingCloudPage.propTypes = {
    getUsersCompanyCloudInvitations: PropTypes.func.isRequired,
    cloudInvitations: PropTypes.array.isRequired,
};

const mapStateToProps = state => ({
    cloudInvitations: state.user.cloudInvitations,
});

export default connect(mapStateToProps , {navigateAppPage, getUsersCompanyCloudInvitations})(PendingCloudPage);
