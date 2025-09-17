const { 
  Button,
  SelectControl,
  CheckboxControl 
} = wp.components

export default props => {

	const publish = () => {

		props.dispatch({
      publishing: true,
      message: 'publicando...'
    })
    
    const url = `${state.admindata.manager_api_url }/partner/publish/post`
    const body = {
      userid: props.state.user.id,
      what: props.state.publishnowwhat,
      where: props.state.publishnowwhere,
      excerpt: props.state.post.excerpt,
      content: props.state.post.content,
      image: props.state.postimage,
      tags: props.state.posttags,
      publishtags: props.state.publishtags
    }

    const config = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(body) 
    } 

    fetch(
      url,
      config
    )
    .then(
      result => result // TODO manage error codes
      .json()
      .then(
        published => {

          console.log(published)

          if(published.ok) {      

            props.dispatch({
              message: 'Publicado'
            })

            setTimeout(() => {      

              props.dispatch({
                publishing: false,
                message: ''
              })

            }, 2000)

          } else {

            props.dispatch({
              message: 'Error: ' + published.description
            })

            setTimeout(() => {      

              props.dispatch({
                publishing: false,
                message: ''
              })

            }, 2000)
          }
        }
      )
    )
	}

	return <div className="PublishNow">
    <SelectControl
      className="WhatPublish"
      label="Que quieres publicar"
      value={ props.state.publishnowwhat }
      options={ props.state.publishwhat }
      onChange={ 
        value => props.dispatch({
          publishnowwhat: value
        }) 
      }
    />
    <CheckboxControl
      className="PublishTags"
      label="Publicar con tags"
      checked={ props.state.publishtags }
      onChange={ 
        checked => props.dispatch({
          publishtags: checked
        }) 
      }
    />
    <SelectControl
      className="WherePublish"
      label="Dónde publicarlo"
      value={ props.state.publishnowwhere }
      options={ props.state.publishwhere }
      multiple
      onChange={ 
        values => props.dispatch({
          publishnowwhere: values
        }) 
      }
    />
    <Button
      variant="primary"
      disabled={  
        props.state.postchanged
        ||
        !props.state.publishnowwhere.length
        ||
        props.state.publishing 
      }
      onClick={ publish }
    >
      {
        props.state.postchanged ?
        'Guardar antes de publicar'
        :
        'Publicar ahora'
      }
    </Button>
    <div className="Message">
      {
        props.state.message != '' &&
        props.state.message
      }
    </div>
  </div>
}