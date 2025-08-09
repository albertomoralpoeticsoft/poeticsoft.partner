const { 
  Button,
  SelectControl
} = wp.components

export default props => {	

  const postId = wp.data
  .select('core/editor')
  .getCurrentPostId();

	const publish = () => {

		props.dispatch({
      publishing: true,
      message: 'publicando...'
    })
    
    const what = props.state.publishnowwhat
    const where = props.state.publishnowwhere.join(',')
    const url = '/wp-json/poeticsoft/telegram/publishwp?' +
      `what=${ what }&` +
      `where=${ where }&` +
      `postid=${ postId }`

    console.log(url)

    fetch(url)
    .then(
      result => result
      .json()
      .then(
        published => {

          console.log(published)

          if(published.ok) {

            props.dispatch({
              publishing: false,
              message: ''
            })

          } else {

            props.dispatch({
              publishing: false,
              message: 'Error: ' + published.description
            })

            setTimeout(() => {      

              props.dispatch({
                message: ''
              })

            }, 2000)
          }
        }
      )
    )
	}

	return <div className="PublishNow">
    <div className="Title">
      Publicar ahora
    </div>
    <SelectControl
      className="WhatPublish"
      label="Que quieres publicar"
      value={ props.state.publishnowwhat }
      options={ props.state.publishwhat }
      onChange={ 
        value => props.dispatch({
          type: 'PUBLISH_RULES_UPDATE_PUBLISHNOWWHAT',
          payload: value
        }) 
      }
    />
    <SelectControl
      className="WherePublish"
      label="Dónde publicarlo"
      value={ props.state.publishnowwhere }
      options={ props.state.userdestinations }
      multiple
      onChange={ 
        values => props.dispatch({
          type: 'PUBLISH_RULES_UPDATE_PUBLISHNOWWHERE',
          payload: values
        }) 
      }
    />
    <Button
      variant="primary"
      disabled={  
        !props.state.publishnowwhat.length
        ||
        !props.state.publishnowwhere.length
        ||
        props.state.publishing 
      }
      onClick={ publish }
    >
      Publicar ahora
    </Button>
    <div className="Message">
      {
        props.state.message != '' &&
        props.state.message
      }
    </div>
  </div>
}