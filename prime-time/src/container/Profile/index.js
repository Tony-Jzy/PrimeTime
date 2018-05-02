import React, { Component } from 'react';
import ReactList from 'react-list';
import MediaCard from '../../component/MediaCard/index.js';
import Spinner from '../../component/Spinner/index.js';

import styled from 'styled-components'

import './Profile.scss';
import './Slide.css'
import * as ENDPOINT from "../../component/App/endpoint";

const StyledProfileCard = styled.div`
  position: relative;
  background-color: #fff;
  box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.5);
  /* margin: auto; */
  text-align: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
  border-width: 1px;
`;

const StyledProfileCard2 = styled.div`
    position: relative;
    box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.5);
    background-color: #fff;
    text-align: center;
    margin-bottom: 20px;
    padding: 0 2.8rem;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    border-width: 1px;
`;

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
`;

const StyledName = styled.div`
  color: #333;
  font-weight: 600;
  font-size: 1.3rem;
  line-height: 2;
`;

const StyledDescription = styled.div`
  font-size: 1.083rem;
  color: #999;
  padding: 0 2.8rem;
  line-height: 1.8;
  margin-bottom: 20px;
`;

const cacheCheck = localStorage.getItem("userInfo");

class Profile extends Component {

    constructor() {
        super();
        this.state = {
            userInfo:'',
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
    fetchMedia = () =>{
        fetch(`${ENDPOINT.BASE}${ENDPOINT.FETCH_MEDIA}?username=${JSON.parse(cacheCheck).user.username}`,{
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

    userLogOut = () => {
        localStorage.removeItem("userInfo");
        this.setState({isLoaded:false});
        this.props.history.push('/');
    };

    componentDidMount() {
        if (cacheCheck) {
            this.setState({userInfo: JSON.parse(cacheCheck)});
            this.fetchMedia();
        }
    }


    render() {

        if (this.state.isLoaded === false) {
            return (
                <div className={'Profile'}>
                    <div className={'background'}>
                        <div className={'panel'}>
                            <div className={'img-container'}>
                                <img src={'https://images.pexels.com/photos/192323/pexels-photo-192323.jpeg?cs=srgb&dl=35mm-antique-black-192323.jpg&fm=jpg'} />
                            </div>

                            <div className={'content-container'}>
                                <Spinner/>
                            </div>
                        </div>
                    </div>
                </div>
            );
        } else {
            return (
                <div className={'Profile'}>
                    <div className={'background'}>
                        <div className={'panel'}>
                            <div className={'img-container'}>
                                <img src={'https://images.pexels.com/photos/192323/pexels-photo-192323.jpeg?cs=srgb&dl=35mm-antique-black-192323.jpg&fm=jpg'} />
                                <div className={'profile-container'}>
                                    <StyledProfileCard>
                                        <div>
                                            <StyledImgContainer>
                                            <img src={this.state.userInfo.user.profile_picture} alt="duck" />
                                        </StyledImgContainer>
                                            <StyledName>{this.state.userInfo.user.full_name}</StyledName>
                                            <StyledDescription>
                                                {this.state.userInfo.user.username}
                                            </StyledDescription>
                                        </div>
                                    </StyledProfileCard>

                                    <StyledProfileCard2>
                                        <StyledName>{'Your Prime Time: '}</StyledName>
                                        <StyledName>{'8:35PM '}</StyledName>
                                    </StyledProfileCard2>

                                    <StyledProfileCard2>
                                        <StyledName>
                                            <p onClick={this.userLogOut}>LOG OUT</p>
                                        </StyledName>
                                    </StyledProfileCard2>


                                </div>
                            </div>

                            <div className={'content-container'}>
                                <div style={{overflow: 'auto', maxHeight: '100%', maxWidth:'95%', margin:'auto',textAlign:'center'}}>
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
}





export default Profile;
