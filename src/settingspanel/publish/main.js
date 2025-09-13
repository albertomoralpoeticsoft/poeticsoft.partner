import moment from 'moment'
moment.locale('es')
const { 
  registerPlugin 
} = wp.plugins
const { 
  PluginDocumentSettingPanel 
} = wp.editPost
const { 
  useEntityProp 
} = wp.coreData
const { 
  useEffect,
  useReducer
} = wp.element

import './main.scss'
import PublishNow from './editor/publishnow'
import PublishRules from './editor/publishrules'
import State from './editor/state'

const PoeticsoftPostSettingsPublish = () => {

	const postType = wp.data
  .select('core/editor')
  .getCurrentPostType()

	if (postType !== 'template') {

		return null
	}

  const [ meta, setMeta ] = useEntityProp(
    'postType', 
    'template', 
    'meta'
  )
  const [ state, localDispatch ] = State(
    useReducer,
    setMeta,
    setMeta
  )
  
  useEffect(() => {

    fetch('/wp-json/poeticsoft/telegram/destinations')
    .then(
      result => result
      .json()
      .then(
        list => {

          const wheredefault = list.find(w => w.default)
          const whatdefault = state.publishwhat.find(w => w.default)
          
          localDispatch({
            destinations: list,
            publishnowwhat: whatdefault.value,
            publishnowwhere: [wheredefault.value]
          })
        }
      )
    )

    localDispatch({
      type: 'PUBLISH_RULES_LOAD',
      payload: meta?.poeticsoft_template_publish_rules || '[]'
    })

  }, [])

	return <PluginDocumentSettingPanel
    name="poeticsoft-post-settings-publish"
    title="Publicación"
    className="poeticsoft-post-settings-publish"
  >
    <PublishNow 
      meta={ meta }
      setMeta={ setMeta }
      state={ state } 
      localDispatch={ localDispatch }
    />
    <PublishRules  
      meta={ meta }
      setMeta={ setMeta }
      state={ state } 
      localDispatch={ localDispatch }
    />
  </PluginDocumentSettingPanel>
}

registerPlugin(
  'poeticsoft-post-settings-publish', 
  {
	  render: PoeticsoftPostSettingsPublish,
    icon: null,
  }
)