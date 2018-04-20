import React, { Component } from 'react';
import classNames from 'classnames';
import { TransitionGroup, CSSTransition } from "react-transition-group";
import { Link } from "react-router-dom";
import ReactList from 'react-list';
import MediaCard from '../../component/MediaCard/index.js';

import {retrieve, authenticate, update} from "../../component/App/auth";

import styled from 'styled-components'

import './Profile.scss';
import './Slide.css'
import * as ENDPOINT from "../../endpoint";

const StyledProfileCard = styled.div`
  position: absolute;
  top: 15%;
  background-color: #fff;
  box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.5);
  /* margin: auto; */
  text-align: center;
  margin-bottom: 20px;
`

const StyledImgContainer = styled.div`
  height: 150px;
  padding-top: 30px;
  padding-left: 30px;
  padding-right: 30px;

  & img {
    width: 120px;
    height: 120px;
    padding: 2px;
    border: 1px solid #eee;
  }
`

const StyledName = styled.div`
  color: #333;
  font-weight: 600;
  font-size: 1.3rem;
  line-height: 2;
`

const StyledDescription = styled.div`
  font-size: 1.083rem;
  color: #999;
  padding: 0 2.8rem;
  line-height: 1.8;
  margin-bottom: 20px;
`

const StyledInfoContainer = styled.div`
  box-sizing: content-box;
  width: 200px;
  margin: 0 auto;
  margin-bottom: 20px;
`

const StyledInfo = styled.div`
  display: inline-block;
  padding: 0 10px;
  line-height: 1.4;
  font-size: 1.167rem;

  border-left: 1px solid #eee;
  &:first-child {
    border: none;
  }

  & a span:first-child {
    color: #585858;
    display: block;
    font-weight: 900;
    font-size: 1.3rem;
  }

  & a span:last-child {
    display: block;
    font-weight: 400;
    font-size: 1.2rem;
    color: #999;
  }
`




class Profile extends Component {

    constructor() {
        super();
        this.state = {
            userInfo:'',
            auth:'',
            offset:0,
            pageSize: 10,
            medias: [],
            profilePic : '',
            numPosts : 0,
            numFollowers : 0,
            numFollowing : 0,
            isLoaded:false
        }

    }
    fetchMedia = () => {
        fetch(`${ENDPOINT.BASE}${ENDPOINT.FETCH_MEDIA}?uid=${this.state.userInfo.uid}&offset=${this.state.offset}&pageSize=${this.state.pageSize}`,{

            headers: {
                'Accept' : 'application/json'
            },
        }).then( response => {
            return response.json();
        }) .then(
            json => {
                this.setState({medias:json.data});
                this.setState({isLoaded:true});
            },
            error => {
                console.log(error);
            }
        )

    };

    renderItem(index, key) {
        return <div key={key}>
            <MediaCard
                media={this.state.medias[index]}
            />
        </div>;
    }

    componentDidMount() {
        this.fetchMedia();
    }

    componentWillMount() {

        this.setState({userInfo:retrieve()});
        this.setState({auth:authenticate()});
    }


    render() {
        if (this.state.isLoaded === false) {
            return (
                <div className={'Profile'}>
                    <div className={'background'}>
                        <div className={'panel'}>
                            <div className={'img-container'}>
                                <img src={'https://images.pexels.com/photos/816708/pexels-photo-816708.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'} />
                                <StyledProfileCard>
                                    <StyledImgContainer>
                                        <img src={'https://images.pexels.com/photos/816708/pexels-photo-816708.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'} alt="duck" />
                                    </StyledImgContainer>
                                    <StyledName>Username</StyledName>
                                    <StyledDescription>
                                        ins_username
                                    </StyledDescription>
                                </StyledProfileCard>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
        return (
            <div className={'Profile'}>
                <div className={'background'}>
                    <div className={'panel'}>
                        <div className={'img-container'}>
                            <img src={'https://images.pexels.com/photos/816708/pexels-photo-816708.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'} />
                            <StyledProfileCard>
                                <StyledImgContainer>
                                    <img src={'https://images.pexels.com/photos/816708/pexels-photo-816708.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'} alt="duck" />
                                </StyledImgContainer>
                                <StyledName>{this.state.userInfo.username}</StyledName>
                                <StyledDescription>
                                    {this.state.userInfo.ins_username}
                                </StyledDescription>
                            </StyledProfileCard>
                        </div>

                        <div className={'signin-container'}>
                            <div style={{overflow: 'auto', maxHeight: '100%', maxWidth:'100%', textAlign:'center'}}>
                                <ReactList
                                    itemRenderer={this.renderItem.bind(this)}
                                    length={this.state.medias.length}
                                    type='uniform'
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}





export default Profile;
