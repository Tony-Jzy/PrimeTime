import React, { Component } from 'react';
import classNames from 'classnames';
import { Link } from "react-router-dom";

import './Header.scss';
import logo from './assets/GlobalJoyLogo.png';


export default class Header extends Component {
    constructor() {
        super();
    }

    render() {
        return (
            <div className={'Header'}>
                <div className={'logo-container'}>
                    <img src={logo} className={'logo'} alt="logo" />
                </div>

                <h1 className={'header-title'}>Global Joy</h1>

                <div className={'button-group'}>
                    <div className={'header-button'}>
                        <Link to="/intro">
                            <p> How It Works </p>
                        </Link>
                    </div>
                    <div className={'header-button'}>
                        <p> The Council </p>
                    </div>
                    <div className={'header-button'}>
                        <p> Coach Sign Up </p>
                    </div>
                    <div className={classNames('header-button', 'button-solid')}>
                        <Link to="/signin">
                            <p> Sign in </p>
                        </Link>
                    </div>
                </div>

            </div>
        );
    }
}