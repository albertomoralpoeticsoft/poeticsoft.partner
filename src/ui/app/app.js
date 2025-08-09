const { 
  useEffect,
  useReducer
} = wp.element
const { 
  Button,
  Panel, 
  PanelBody
} = wp.components

import User from './editor/user'
import State from './editor/state'
import PublishNow from './editor/publishnow'
import PublishRules from './editor/publishrules'

export default props => {

  const [ state, dispatch ] = State()

  useEffect(() => {

    fetch('https://poeticsoft.com/wp-json/poeticsoft/manager/partner/data')
    .then(
      result => result
      .json()
      .then(
        partnerdata => {

          dispatch(partnerdata)
        }
      )
    )

  }, []) 
 
  return <div className="app">
    <Panel>
      <PanelBody>      
        <User
          state={ state } 
          dispatch={ dispatch }
        />      
        <PublishNow
          state={ state } 
          dispatch={ dispatch }
        />
        <PublishRules
          state={ state } 
          dispatch={ dispatch }
        />
      </PanelBody>
    </Panel>
  </div>
}
