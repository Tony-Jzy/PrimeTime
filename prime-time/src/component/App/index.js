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
                            <Route exact path="/profile" component={Profile} />
                        </Switch>
                    </CSSTransition>
                </TransitionGroup>
            )}

        />
    </Router>
);




export default App;
