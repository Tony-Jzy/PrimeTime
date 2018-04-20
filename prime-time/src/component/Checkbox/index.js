import React, { Component } from 'react';
import classNames from 'classnames';

import './Checkbox.scss';
import check from './assets/checkmark.svg'


export default class Checkbox extends Component {

    constructor() {
        super();
    }

    render() {
        const { checked, handleClick } = this.props

        return (
            <div
                onClick={handleClick}
                className={classNames('Checkbox', checked ? 'checked' : '')}>
                {
                    checked ?
                        <img src={check} />
                        :
                        null
                }

            </div>

        )
    }

}