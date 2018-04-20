import React, { Component } from 'react';
import './Intro.scss';
import Banner from '../../component/Banner'
import classNames from 'classnames';


//Need to optimize the render
class Intro extends Component {
    constructor() {
        super()
        this.state = {
            windowHeight: 0,
            scrollY: 0,
            isBg2: false,
        }
    }

    componentDidMount() {
        window.addEventListener('scroll', this.handleScroll);
        window.addEventListener('resize', this.handleResize);
        this.setState({windowHeight: window.innerHeight})
        console.log(window.innerHeight, 'innerheight at didmount')
    }

    componentWillUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
    }

    handleScroll = (event) => {
        // do something like call `this.setState`
        // access window.scrollY etc
        this.setState({scrollY: window.scrollY})

        const scrollY = window.scrollY


    }

    handleResize = (event) => {
        this.setState({widdowHeight: window.innerHeight})
        //console.log(window.innerHeight, 'innerheight at resize')
    }

    render() {
        let isBg2 = window.scrollY > window.innerHeight;

        return(
            <div className={classNames(isBg2 ? 'bg2' : 'bg1', 'Intro')}>
                <Banner />
                <div className={'slogan-div'}>
                    <h1> Slogan </h1>
                </div>
                <div className={'feature-div'}>
                    <h1> Key Features</h1>
                </div>
                <div className={'more-div'}>

                </div>

            </div>
        )
    }
}

export default Intro;