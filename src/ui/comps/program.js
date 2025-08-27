const { 
  Panel, 
  PanelBody
} = wp.components

import PublishNow from './program/publishnow'
import PublishRules from './program/publishrules'

export default props => {
 
  return <Panel>
    <PanelBody>
      <PublishNow
        state={ props.state } 
        dispatch={ props.dispatch }
      />
      <PublishRules
        state={ props.state } 
        dispatch={ props.dispatch }
      />
    </PanelBody>
  </Panel>
}
