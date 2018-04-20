import React from "react";
import {
    BrowserRouter as Router,
    Route,
    Switch,
} from "react-router-dom";
import Loadable from 'react-loadable';
import { TransitionGroup, CSSTransition } from "react-transition-group";
import './fade.css';


const Loading = () => <div></div>;

const HomePage = Loadable({
    loader: () => import('../../container/HomePage'),
    loading: Loading,
});
const Intro = Loadable({
    loader: () => import('../../container/Intro'),
    loading: Loading,
});
const SignIn = Loadable({
    loader: () => import('../../container/SignIn'),
    loading: Loading,
});
const Main = Loadable({
    loader: () => import('../../container/Main'),
    loading: Loading,
});
const Profile = Loadable({
    loader: () => import('../../container/Profile'),
    loading: Loading,
});



const App = () => (
    <Router>
        <Route
            render = {({ location }) => (
                <TransitionGroup>
                    <CSSTransition key={location.key} classNames="fade" timeout={300}>
                        <Switch location={location}>
                            <Route
                                exact
                                path="/"
                                component={Main}
                            />
                            <Route exact path="/signin" component={SignIn} />
                            <Route exact path="/intro" component={Intro} />
                            <Route exact path="/profile" component={Profile} />
                        </Switch>
                    </CSSTransition>
                </TransitionGroup>
            )}

        />
    </Router>
);




export default App;
