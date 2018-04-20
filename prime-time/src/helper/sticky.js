import React from 'react';

export default function sticky(Component) {
    class StickyView extends React.Component {
        constructor(props) {
            super(props)
            // In es6 react components, this is used instead of `getInitialState`
            // the loop just is a lazy version of hand-assigning each default property to the state, without inheriting _all_ properties (some will be intended for the inheriting component).
            this.state = this.state || {}
            for (let k in StickyView.defaultProps) {
                this.state[k] = props[k]
            }
        }

        componentDidMount {
            window.addEventListener("scroll", this.onScroll, false);
        }

        componentWillUnmount{
            window.removeEventListener("scroll", this.onScroll, false);
        }

        onScroll{
            if (window.scrollY >= 100 && !this.state.sticky) {
                this.setState({sticky: true});
            } else if (window.scrollY < 100 && this.state.sticky) {
                this.setState({sticky: false});
            }
        },
        render() {
            return <div className="sticky-container" style={{'background-color':'#f2f;'}}>
                <Component {...this.props} {...this.state}/>
            </div>
        }
    }
    // Top margin here to demonstrate that sub components share props.
    StickyView.defaultProps = { topMargin: 0, sticky: false }
    return StickyView
}