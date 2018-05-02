import React, { Component } from 'react';
import classNames from 'classnames';
import { withRouter } from "react-router-dom";
import {update} from '../../component/App/auth';
import './main.scss';
import './main.css'
import INS_LOGO from './assets/instagram.png';
import InputForm from '../../component/InputForm';

import * as ENDPOINT from '../../component/App/endpoint';
import {INS_AUTHORIZATION} from "../../component/App/endpoint";
import {INS_TOKEN_REQUEST} from "../../component/App/endpoint";
import {ins_client_id} from "../../component/App/endpoint";
import {ins_client_secret} from "../../component/App/endpoint";
import {ins_grant_type} from "../../component/App/endpoint";
import {ins_redirect_uri} from "../../component/App/endpoint";

let URLSearchParams = require('url-search-params');


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
                update(json.data);
                this.setState({isLogin:true});
                this.props.history.push('/profile');
            },
            error => {
                console.log(error);
            }
        )
    };

    InsAuthorBegin = () => {
        window.location.href = INS_AUTHORIZATION;
    };

    InsTokenRequest = () => {

        const search = this.props.location.search;
        const params = new URLSearchParams(search);
        const code = params.get('code');

        let data = {
            client_id : ins_client_id,
            client_secret : ins_client_secret,
            grant_type : ins_grant_type,
            redirect_uri : ins_redirect_uri,
            code : code
        };

        let formData = new FormData();

        for (let name in data) {
            formData.append(name, data[name])
        }

        fetch(`${INS_TOKEN_REQUEST}`,{
            method: 'POST',
            body : formData
        }).then( response => {
            return response.json()
        }) .then(
            json => {
                console.log(json);
                localStorage.setItem("userInfo", JSON.stringify(json));
                update(json);
                if (json.access_token !== undefined) {
                    this.props.history.push('/profile')
                }
            },
            error => {
                console.log(error);
            }
        )
    };

    componentWillMount() {
        if (this.props.location.search !== "") {
            const params = new URLSearchParams(this.props.location.search);
            const code = params.get('code');

            if (code !== null || code !== "") {
                this.InsTokenRequest()
            }
        }
    }

    render() {
        return (
            <div className={'SignIn'}>

                <div className={'banner'}>
                    <div id="pic3"></div>
                    <div id="pic2"></div>
                    <div id="pic1"></div>
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
                        <p className={'content'}> It is  </p>
                        </div>
                        <div>
                        <p className={'highlight'}> time </p>
                        </div>
                        <div>
                        <p className={'content'}> to </p>
                        </div>
                        <div>
                        <p className={'highlight'}>   post </p>
                        </div>
                        <div>
                        <p className={'content'}> now. </p>
                        </div>
                        <div>
                        <p className={'subcontent'}> #Instagram </p>
                        </div>
                        <div>
                        <p className={'firstword'}> #PrimeTime </p>
                        </div>
                    <div className={'panel'}>
                        <div className={'form-container'}>
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
                                        <div className={'input-section'}>
                                            <InputForm
                                                handleChange={(event) => {
                                                    this.setState({username: event.target.value})
                                                }}
                                                title={'UserName'}
                                                placeholder={'UserName'}
                                                value={this.state.username}
                                                type={'text'}
                                                color={'white'}
                                                />
                                        </div>
                                        <div className={'input-section'}>
                                            <InputForm
                                                handleChange={(event) => {
                                                    this.setState({pass: event.target.value})
                                                }}
                                                title={'Password'}
                                                placeholder={'Password'}
                                                value={this.state.pass}
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
                                    <div className={classNames('button-container', 'instagram')} onClick={this.InsAuthorBegin}>
                                        <img src={INS_LOGO} />
                                        <p> Instagram</p>
                                    </div>
                                </div>

                                <div className={'author'}>
                                    <p> By CS411 Team2</p>
                                </div>

                            </div>
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
