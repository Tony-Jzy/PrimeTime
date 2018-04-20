import React, { Component } from 'react';
import { Link } from "react-router-dom";

import Carousel from 'nuka-carousel';

import './HomePage.scss';
import MainSearch from '../../component/MainSearch';
import Header from '../../component/Header';
import IconText from '../../component/IconText';

import icon1 from './assets/icon1.svg';
import icon2 from './assets/icon2.svg';
import icon3 from './assets/icon3.svg';
import icon4 from './assets/icon4.svg';

import legend3 from './assets/legend1.jpg';
import legend4 from './assets/legend4.jpg';




class HomePage extends Component {
    constructor() {
        super();

        this.state = {
            mainSearchText: '',
        }
    }

    _handleResize = () => {
        this._handleResize.bind(this)
    }

    componentDidMount() {
        this.carousel.setDimensions()
        window.addEventListener("resize", this._handleResize.bind(this));
    }

    componentWillUnmount() {
        window.removeEventListener("resize", this._handleResize.bind(this));
    }

    handleSearchChange = (event) => {
        this.setState({mainSearchText: event.target.value})
    }

    handleCancelSearch = () => {
        this.setState({mainSearchText: ''})
    }

    handleKeyPress = (event) => {
        if (event.key === 'Enter') {
            console.log('Search', this.state.mainSearchText)
        }
    }

    _handleLoadImage = () => {
        this.carousel.setDimensions()
    }

    render() {
        return (
          <div className={'HomePage'}>
              <Header />
              <div className={'header-background'} />
              <div className={'search-div'}>
                  <Carousel
                      ref={c => this.carousel = c}
                      renderCenterLeftControls={({ previousSlide }) => (
                          <div />
                      )}
                      renderCenterRightControls={({ nextSlide }) => (
                          <div />
                      )}
                  >
                      <img className={'legend-img'} src={legend3} onLoad={this._handleLoadImage}/>
                      <img className={'legend-img'} src={legend4} onLoad={this._handleLoadImage}/>
                  </Carousel>

                  <MainSearch
                      handleChange={this.handleSearchChange}
                      placeholder={'Type in your health related question' }
                      value={this.state.mainSearchText}
                      cancel={this.handleCancelSearch}
                      handleKeyPress={this.handleKeyPress}
                  />
              </div>
              <div className={'category-div'}>

                  <IconText
                      text={'Beautiful Mind'}
                      imgSrc={'https://gss0.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/zhidao/pic/item/a8014c086e061d9538f5e60a71f40ad162d9ca55.jpg'}/>
                  <IconText
                      text={'Love Green'}
                      imgSrc={'https://static-maquia.hpplus.jp/upload/image/manager/25/EGIXA1Q-1200.jpg'}/>
                  <IconText
                      text={'What is this'}
                      imgSrc={'https://imagelab.nownews.com/?w=1080&q=85&src=http://s.nownews.com/15/c3/15c3717ddf797d1234d69524d0217408.jpg'}/>
              </div>


              <div className={'intro-div'}>
                  <h1 className={'intro-title'}> How It Works? </h1>
                  <div className={'divider'} />
              </div>
          </div>
        );
      }
}

export default HomePage;
