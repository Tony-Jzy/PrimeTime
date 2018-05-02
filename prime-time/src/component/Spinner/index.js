import React from 'react';
import './Spinner.scss';
import spinner from './assets/puff.svg';

const Spinner = props =>
    <div className={'Spinner'}>
        <img src={spinner}/>
    </div>;

export default Spinner;