import React, { Component } from 'react';
import classNames from 'classnames';
import { TransitionGroup, CSSTransition } from "react-transition-group";
import { Link } from "react-router-dom";

import './SignIn.scss';
import './Slide.css'
import FB_LOGO from './assets/facebook.png';
import TW_LOGO from './assets/twitter.png';

import Header from '../../component/Header';
import InputForm from '../../component/InputForm';
import Checkbox from '../../component/Checkbox';


class SignIn extends Component {

    constructor() {
        super();
        this.state = {
            signUpForm: false,
            email: '',
            pass: '',

            firstname: '',
            lastname: '',
            newemail: '',
            newpass: '',
            agreeToTerm: false,
            isTrainer: false,
            isTrainee: false,
        }

    }

    _handleChangeTab = () => {
        const tempBool = !this.state.signUpForm
        this.setState({
            signUpForm: tempBool
        });
    }

    handleInputChange = (event) => {
        this.setState({mainSearchText: event.target.value})
    }

    handleKeyPress = (event) => {
        if (event.key === 'Enter') {
            console.log('Search', this.state.mainSearchText)
        }
    }

    render() {
        return (
            <div className={'SignIn'}>
                <Header />
                <div className={'background'}>
                    <div className={'panel'}>
                        <div className={'img-container'}>
                            <img src={'https://stat.7gogo.jp/appimg_images/20180126/21/04/rX/j/o19201707p.jpg'} />
                        </div>
                        <div className={'form-container'}>
                            {
                                !this.state.signUpForm ?
                                    <div className={'signin-container'}>
                                        <div className={'tab-section'}>
                                            <div>
                                                <p className={'hl-text'}> Sign in </p>
                                            </div>
                                            <p> or </p>
                                            <div onClick={this._handleChangeTab}>
                                                <p className={'link'}> Sign up </p>
                                            </div>
                                         </div>

                                        <div className={'input-section'}>
                                            <InputForm
                                                handleChange={(event) => {
                                                    this.setState({email: event.target.value})
                                                }}
                                                placeholder={''}
                                                value={this.state.email}
                                                title={'EMAIL'}
                                                type={'text'}
                                                />
                                        </div>
                                        <div className={'input-section'}>
                                            <InputForm
                                                handleChange={(event) => {
                                                    this.setState({pass: event.target.value})
                                                }}
                                                placeholder={''}
                                                value={this.state.pass}
                                                title={'Password'}
                                                type={'password'}
                                            />
                                        </div>

                                        <div className={'signin-button-section'}>
                                            <div onClick={this._handleChangeTab}>
                                                <p className={'no-account'}> Don't have an account? </p>
                                            </div>
                                            <div className={'signin-button'}>
                                                <p>Sign in</p>
                                            </div>
                                        </div>

                                        <div className={'button-section'}>
                                            <div className={classNames('button-container', 'facebook')}>
                                                <img src={FB_LOGO} />
                                                <p>Sign in with Facebook</p>
                                            </div>
                                            <div className={classNames('button-container', 'twitter')}>
                                                <img src={TW_LOGO} />
                                                <p>Sign in with Twitter</p>
                                            </div>
                                        </div>

                                    </div>
                                    :
                                    <div className={'signup-container'}>
                                        <div className={'tab-section'}>
                                            <div onClick={this._handleChangeTab}>
                                                <p className={'link'}> Sign in </p>
                                            </div>
                                            <p> or </p>
                                            <div>
                                                <p className={'hl-text'}> Sign up </p>
                                            </div>
                                        </div>

                                        <div className={'selection-name-section'}>
                                            <div className={'side'} >
                                                <div className={'top'}>
                                                    <p>I am a trainee</p>
                                                    <Checkbox
                                                        checked={this.state.isTrainee}
                                                        handleClick={()=> {
                                                            this.setState({
                                                                isTrainee: !this.state.isTrainee
                                                            })
                                                        }}
                                                        />
                                                </div>
                                                <div className={'bot'}>
                                                    <InputForm
                                                        handleChange={(event) => {
                                                            this.setState({firstname: event.target.value})
                                                        }}
                                                        placeholder={''}
                                                        value={this.state.firstname}
                                                        title={'FIRST NAME'}
                                                        type={'text'}
                                                    />
                                                </div>

                                            </div>
                                            <div className={'side'}>
                                                <div className={'top'}>
                                                    <p>I am a trainer</p>
                                                    <Checkbox
                                                        checked={this.state.isTrainer}
                                                        handleClick={()=> {
                                                            this.setState({
                                                                isTrainer: !this.state.isTrainer
                                                            })
                                                        }}
                                                    />
                                                </div>
                                                <div className={'bot'}>
                                                    <InputForm
                                                        handleChange={(event) => {
                                                            this.setState({lastname: event.target.value})
                                                        }}
                                                        placeholder={''}
                                                        value={this.state.lastname}
                                                        title={'LAST NAME'}
                                                        type={'text'}
                                                    />
                                                </div>
                                            </div>

                                        </div>

                                        <div className={'email-pass-section'}>
                                            <div className={'input-section'}>
                                                <InputForm
                                                    handleChange={(event) => {
                                                        this.setState({newemail: event.target.value})
                                                    }}
                                                    placeholder={''}
                                                    value={this.state.newemail}
                                                    title={'EMAIL'}
                                                    type={'text'}
                                                />
                                             </div>
                                                <div className={'input-section'}>
                                                <InputForm
                                                    handleChange={(event) => {
                                                        this.setState({newpass: event.target.value})
                                                    }}
                                                    placeholder={''}
                                                    value={this.state.pass}
                                                    title={'Password'}
                                                    type={'password'}
                                                />
                                            </div>
                                        </div>

                                        <div className={'agree-section'} >
                                            <Checkbox
                                                checked={this.state.agreeToTerm}
                                                handleClick={()=> {
                                                    this.setState({
                                                        agreeToTerm: !this.state.agreeToTerm
                                                    })
                                                }}
                                            />

                                            <p> I agree to the &nbsp;</p>
                                            <p className={'hl-text'}> terms of services </p>
                                        </div>

                                        <div className={'signup-button-section'}>
                                            <div onClick={this._handleChangeTab}>
                                                <p className={'already'}> Already have an account? </p>
                                            </div>
                                            <div className={'signup-button'}>
                                                <p>Sign up</p>
                                            </div>
                                        </div>


                                    </div>

                            }
                        </div>

                    </div>
                </div>
            </div>
        );
    }
}

export default SignIn;
