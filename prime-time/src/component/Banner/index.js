import React, { Component } from 'react';
import classNames from 'classnames';
import './Banner.scss';

class Banner extends Component {
    constructor() {
        super();
        this.state = {
            isScrolled: false,
        };
    }



    render() {
        return(
            <div className={classNames(this.state.isScrolled ? 'is-scrolled' : '', 'Banner')}>
                <div className={'main-div'}>
                    <h1> Banner </h1>
                </div>
                <div className={'scrolled-shadow'} />
            </div>
        )
    }
}

export default Banner;