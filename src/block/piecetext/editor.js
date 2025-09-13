const { __ } = wp.i18n
const { registerBlockType } = wp.blocks
const { useBlockProps } = wp.blockEditor
import metadata from 'block/piecetext/block.json'
import './editor.scss';

const { 
  Panel,
  PanelBody,
  PanelRow,
  TabPanel
} = wp.components

import State from './state'
import Images from './comps/images'
import Videos from './comps/videos'

const Edit = props => {

  const blockProps = useBlockProps()
  
  const [ state, dispatch ] = State()

  return <div 
    { ...blockProps }
  >
    <Panel className="Text">
      <PanelBody  
        className="TextBody"
        title="Text"
        initialOpen={ false }
      >
        <PanelRow
          className="TextRow"
        >
          <TabPanel
            className="Tabs"
            activeClass="Active"
            initialTabName="image"
            tabs={[
              {
                  name: 'image',
                  title: 'Imágenes'
              },
              {
                  name: 'video',
                  title: 'Videos'
              }
            ]}
          >
            { 
              tab => <>
                {
                  tab.name == 'image' &&
                  <Images state={ state } dispatch={ dispatch } />
                }
                {
                  
                  tab.name == 'video' &&            
                  <Videos state={ state } dispatch={ dispatch } />
                }
              </>
            }
          </TabPanel>
        </PanelRow>
      </PanelBody>
    </Panel>
  </div>
}

const Save = props => {

  const blockProps = useBlockProps.save()

  return <div { ...blockProps }>
    SAVE
  </div>
}

registerBlockType(
  metadata.name,
  {
    edit: Edit,
    save: Save
  }
)