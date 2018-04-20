import React, { Component } from 'react';
import './InputForm.scss';

class InputForm extends Component {
    constructor() {
        super();
        this.state = {
            isFocused: false
        }
    }
    onFocus = () => {
        this.setState({isFocused:true})
    }

    onBlur = () => {
        this.setState({isFocused:false})
    }

    render() {
        const { handleChange, value, placeholder, title, type } = this.props
        let searchInput = null;

        return (
            <div className={'InputForm'}>
                <div className={'title'}>
                    <p>{title}</p>
                </div>
                <div className={'input-container'}>
                    <input
                        ref={input => {
                            searchInput = input;
                        }}
                        placeholder={placeholder}
                        value={value}
                        onFocus={this.onFocus}
                        onBlur={this.onBlur}
                        onChange={(text) => handleChange(text)}
                        type={type}
                    />
                </div>
            </div>
        );
    }
}

export default InputForm;
