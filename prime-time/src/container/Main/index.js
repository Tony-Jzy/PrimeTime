import React, { Component } from 'react';
import classNames from 'classnames';
import { withRouter } from "react-router-dom";

import './main.scss';
import './main.css'
import FB_LOGO from './assets/facebook.png';
import INS_LOGO from './assets/instagram.png';

import InputForm from '../../component/InputForm';
import Checkbox from '../../component/Checkbox';

import { update, withAuth } from '../../component/App/auth';
import * as ENDPOINT from '../../endpoint';

class Main extends Component {

    constructor() {
        super();
        this.state = {
            username: '',
            pass: '',
            isLogin: false
        }
    }

    handleLogin = () => {
        let data = {
            username: this.state.username,
            password: this.state.pass
        };

        fetch(`${ENDPOINT.BASE}${ENDPOINT.LOGIN}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept' : 'application/json'
            },
            body: JSON.stringify(data)
        }).then( response => {
            return response.json()
        }) .then(
            json => {
                console.log(json);
                update(json.data);
                this.setState({isLogin:true});
                this.props.history.push('/profile');
            },
            error => {
                console.log(error);
            }
        )
    };
    render() {
        // if (this.state.isLogin === true) {
        //     return <BrowserRouter path={'/profile'}/>
        // }
        return (
            <div className={'SignIn'}>
                <div className={'background'}>
                    <div className={'panel'}>
                        <div className={'img-container'}>
                            <img src={'https://images.pexels.com/photos/816708/pexels-photo-816708.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'} />
                        </div>
                        <div className={'form-container'}>
                            {
                                !this.state.signUpForm ?
                                    <div className={'signin-container'}>
                                        <div className={'title'}>
                                            <div>
                                                <p className={'name'}> PrimeTime </p>
                                            </div>
                                            <div>
                                                <p className={'author'}> by CS411 Team 2 </p>
                                            </div>
                                         </div>

                                        <div className={'input-section'}>
                                            <InputForm
                                                handleChange={(event) => {
                                                    this.setState({username: event.target.value})
                                                }}
                                                placeholder={''}
                                                value={this.state.username}
                                                title={'Account:'}
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
                                                title={'Password:'}
                                                type={'password'}
                                            />
                                        </div>

                                        <div className={'signin-button-section'}>
                                            <div className={'signin-button'} onClick={this.handleLogin}>
                                                <p>Login</p>
                                            </div>
                                        </div>

                                        <div className={'also-can'}>
                                            <p> You can also login with</p>
                                        </div>

                                        <div className={'button-section'}>
                                            <div className={classNames('button-container', 'facebook')}>
                                                <img src={FB_LOGO} />
                                                <p> Facebook</p>
                                            </div>
                                            <div className={classNames('button-container', 'instagram')}>
                                                <img src={INS_LOGO} />
                                                <p> Instagram</p>
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

export default withRouter(Main);
