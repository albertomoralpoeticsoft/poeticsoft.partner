const { 
  useState,
  useEffect
} = wp.element

const { 
  Panel,
  TabPanel,  
  PanelBody,  
  Card,
  CardHeader,
  CardBody,
  CardDivider,
  CardFooter,
  CardMedia,
  Tooltip,
  SelectControl,
  FormTokenField
} = wp.components

const poststype = {
  post: 'Posts',
  attachment: 'Media',
  page: 'Pages'
}

import noimage from 'assets/images/noimage.png'

const Content = props => {

  const [ groups, setGroups ] = useState([])

  const showContent = () => {

    console.log(props)
  }

  const addTokens = tokens => {

    setGroups(tokens)
  }

  return <Card>
    <CardHeader
      onClick={ showContent }
    >
      <Tooltip text={ props.post_title }>
        <span>{ props.post_title }</span>
      </Tooltip>
    </CardHeader>
    <CardMedia>
      {
        (
          (
            props.post_type == 'post'
            ||
            props.post_type == 'page'
          )
          &&
          props.image
        ) ?
        <img src={ props.image } />
        :
        <img src={ noimage } />
      }
    </CardMedia>
    <CardFooter>      
      <FormTokenField 
        className="Grupos"
        value={ groups }
        suggestions={ props.state.groups.map(g => g.label) }
        onChange={ addTokens }
        placeholder="Añade a grupos"
        __experimentalShowHowTo={ false }
      />
    </CardFooter>
  </Card>
}

const Contents = props => {

  return <Panel className="Contents">
    <PanelBody>
      {
        Object.keys(props.state.posts[props.type])
        .map(key => <Content 
          { ...props.state.posts[props.type][key] } 
          state={ props.state } 
          dispatch={ props.dispatch }
        />)
      }
    </PanelBody>
  </Panel>
}

export default props => {

  return <Panel>
    <PanelBody>
      <TabPanel
        className="PoeticsoftPartnersTools"
        activeClass="Active"
        initialTabName={ Object.keys(props.state.posts)[0] }
        tabs={
          Object.keys(props.state.posts)
          .map(key => ({
            name: key,
            title: poststype[key]
          }))
        }
      >
        { 
          tab => <>
            {
              Object.keys(props.state.posts)
              .map(key => <>
                {
                  tab.name == key &&
                  <Contents 
                    type={ key } 
                    state={ props.state } 
                    dispatch={ props.dispatch } 
                  />                
                }
              </>)
            }
          </> 
        }
      </TabPanel>
    </PanelBody>
  </Panel>
}