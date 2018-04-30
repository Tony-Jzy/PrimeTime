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
                    <div className={'head'}>
                        <div>
                        <p className={'name1'}> P </p>
                        <p className={'name2'}> R </p>
                        <p className={'name3'}> I </p>
                        <p className={'name2'}> M </p>
                        <p className={'name1'}> E </p>
                        </div>
                    <div className={'head2'}>
                        <div>
                        <p className={'name3'}> T </p>
                        <p className={'name2'}> I </p>
                        <p className={'name1'}> M </p>
                        <p className={'name2'}> E </p>
                        </div>
                    <div className={'subtitle'}>
                        <div>
                        <p className={'firstword'}> It </p>
                        </div>
                        <div>
                        <p className={'content'}> is </p>
                        </div>
                        <div>
                        <p className={'highlight'}> time </p>
                        </div>
                        <div>
                        <p className={'content'}> to </p>
                        </div>
                        <div>
                        <p className={'highlight'}> post </p>
                        </div>
                        <div>
                        <p className={'content'}> . </p>
                        </div>
                    <div className={'panel'}>
                        <div className={'form-container'}>
                            {
                                !this.state.signUpForm ?
                                    <div className={'signin-container'}>
                                        <div className={'title'}>
                                            <div>
                                                <p className={'subname'}> log in </p>
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
                                                color={'white'}
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
                                                <p>Sign In</p>
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

                                        <div className={'author'}>
                                            <p> By CS411 Team2</p>
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
                </div>
            </div>
            </div>
        );
    }
}

export default withRouter(Main);
