import React from 'react';

let state ={

};

const subscribers = [];

const unsubscribe = subscriber => {
    const index = subscribers.findIndex(subscriber);
    ~index && subscribers.splice(index, 1);
};
const subscribe = subscriber => {
    subscribers.push(subscriber);
    return () => unsubscribe(subscriber);
};

export const withAuth = Component => {
    return class WithAuth extends React.Component {
        componentDidMount() {
            this.unsubscribe = subscribe(this.forceUpdate.bind(this));
        }
        render() {
            const newProps = { ...this.props, auth: state };
            return <Component {...newProps} />;
        }
        componentWillUnmoount() {
            this.unsubscribe();
        }
    };
};

export const update = newState => {
    state = newState;
    subscribers.forEach(subscriber => subscriber());
};

export const retrieve = () => {
    return state.userInfo;
};

export const authenticate = () => {
    return state.authenInfo;
};