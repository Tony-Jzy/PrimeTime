import React, { Component } from 'react';
import { Link } from "react-router-dom";
import * as moment from 'moment';

import './MediaCard.scss'

export default class MediaCard extends Component {
    constructor() {
        super();

    }

    dateString = (timestamp) => {
        let t = new Date(timestamp*1000);
        return moment(t).format("llll");
    };


    render() {
        const { media } = this.props;

        return (
            <div className={'MediaCard'}>
                <div className={'image-container'}>
                    <img src={media.image_link} />
                </div>
                <div className={'text-container'}>
                    <div className={'text-tab'}>
                        <div>Like:</div>
                        <div>{media.num_like}</div>
                    </div>

                    <div className={'text-tab'}>
                        <div>Comment:</div>
                        <div>{media.num_comment}</div>
                    </div>

                    <div className={'text-tab'}>
                        <div>Created:</div>
                        <div>{this.dateString(parseFloat(media.created))}</div>
                    </div>
                </div>
            </div>
        );
    }
}