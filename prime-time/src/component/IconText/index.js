import React, { Component } from 'react';
import { Link } from "react-router-dom";

import './IconText.scss'

export default class IconText extends Component {
    constructor() {
        super();

    }

    render() {
        const { imgSrc, text } = this.props;

        return (
            <div className={'IconText'}>
                <div className={'ring-container'}>
                    <div className={'image-container'}>
                        <img src={imgSrc} />
                    </div>
                </div>
                <div className={'text-container'}>
                    <p>{text}</p>
                </div>
            </div>
        );
    }
}