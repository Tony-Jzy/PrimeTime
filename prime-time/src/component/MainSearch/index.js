import React, { Component } from 'react';
import './MainSearch.scss';
import Search from './Content.png';

class MainSearch extends Component {

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
        const { handleChange, value, placeholder, cancel, handleKeyPress } = this.props
        let searchInput = null;
        const handleClickSearch = () => {
            searchInput.focus();
        };


        return (
            <div className={'MainSearch'}>
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
                        onKeyPress={handleKeyPress}
                    />
                </div>
                    <div
                        className={'icon-container'}
                        onClick={handleClickSearch}
                    >
                        <img src={Search} className={'icon'} alt="icon"/>
                    </div>
        </div>
        );
    }
}

export default MainSearch;
