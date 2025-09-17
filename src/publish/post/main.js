const { 
  registerPlugin 
} = wp.plugins
const { 
  PluginDocumentSettingPanel 
} = wp.editPost
const {
  useRef
} = wp.element
const { useSelect } = wp.data

import './main.scss'
import PublishNow from './publishnow'
import State from './state'

const PoeticsoftPartnerPublishPost = () => {

  const post = wp.data
  .select('core/editor')
  .getCurrentPost()

	if (post.type !== 'post') {

		return null
	}

  const userRef = useRef(null)

  const [ state, dispatch ] = State()

  window.state = state

  const init = user => {

    fetch(`${state.admindata.manager_api_url }/partner/data/${ user.id }`)
    .then(
      result => result
      .json()
      .then(
        data => {

          dispatch({
            type: 'PUBLISH_DATA_SET',
            payload: data
          })
        }
      )
    )
  }

  useSelect(select => {

    const { 
      getEditedPostAttribute,
      getCurrentPost,
      isEditedPostDirty
    } = select('core/editor');
    const { 
      getCurrentUser,
      getMedia, 
      getEntityRecord 
    } = select('core');    
    const user = getCurrentUser()
    const mediaId = getEditedPostAttribute('featured_media')

    if(user.id && userRef.current == null) {

      userRef.current = user

      dispatch({
        user: user
      })

      init(user)
    }

    let featuredMediaUrl = null
    if (mediaId) {

      const media = getMedia(mediaId);
      featuredMediaUrl = media?.source_url || null;
    }
    const tagIds = getEditedPostAttribute('tags') || [];
    const tagNames = tagIds
      .map((id) => getEntityRecord('taxonomy', 'post_tag', id))
      .filter(Boolean)
      .map(tag => tag.name)

    dispatch({
      post: getCurrentPost(),
      postchanged: isEditedPostDirty(),
      postimage: featuredMediaUrl,
      posttags: tagNames
    })

  }, [] );

	return <PluginDocumentSettingPanel
    name="poeticsoft-partner-publish-post"
    title="Publicar Post"
    className="PoeticsoftPartnerPublishPost"
  >
    <PublishNow
      state={ state } 
      dispatch={ dispatch }
    />
  </PluginDocumentSettingPanel>
}

registerPlugin(
  'poeticsoft-partner-publish-post', 
  {
	  render: PoeticsoftPartnerPublishPost,
    icon: null,
  }
)