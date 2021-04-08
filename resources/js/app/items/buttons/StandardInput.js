import React, {Component} from 'react';
import { connect } from 'react-redux';
import { v4 } from 'uuid';

class StandardInput extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }


    render(){
        var {inputValue, inputName,inputLabel,inputDefaultValue, classes, focus, required} = this.state;
        return (
            <div className={classes}>
                <label className={"lrg-inpt-lbl"}>{inputLabel}</label>
                <input id={inputName}
                       className={"main-inpt"}
                       name={inputName}
                       type={"text"}
                       defaultValue={inputDefaultValue}
                       value={inputValue}
                       autoComplete={"off"}
                       required={required}
                       autoFocus={focus}
                />
                <span className="invalid-feedback" role="alert"></span>
            </div>
        );
    }
}

const mapStateToProps = state => ({

});

export default connect(mapStateToProps , {})(StandardInput);
