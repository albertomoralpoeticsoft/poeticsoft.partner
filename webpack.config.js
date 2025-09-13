const path = require('path')

const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const pluginname = 'poeticsoft-partner'
const destdir = path.join(__dirname, 'wp-content/plugins', pluginname)
const pluginpublic = '/wp-content/plugins/' + pluginname

module.exports = env => {  
                                                    
  const input = Object.keys(env)[2] || ''

  const params = input.split('-')
  const type = params[0] || 'block' // block 
  const name = params[1] || 'base' // base | etc.

  let mode = params[2] || 'dev' // dev | prod

  const paths = {
    output: destdir  + '/' + type + '/' + name,
    public: pluginpublic,
    cssfilename: '[name].css'
  }
  let entry = {}
  let externals = {}  

  const wpexternals = {
    '@wordpress/element': 'wp.element',
    '@wordpress/i18n': 'wp.i18n',
    '@wordpress/blocks': 'wp.blocks'
  }

  switch (type) {

    case 'admin':
    case 'jitsi':
      
      paths.output = destdir  + '/ui/' + type

      entry = {
        main: './src/' + type + '/main.js'
      }

      break

    case 'block':
      
      paths.output = destdir  + '/' + type + '/' + name + '/build'

      entry = {
        editor: './src/' + type + '/' + name + '/editor.js',
        view: './src/' + type + '/' + name + '/view.js'
      }

      externals = wpexternals

      break

    case 'settingspanel':
      
      paths.output = destdir  + '/' + type + '/' + name

      entry = {
        main: './src/' + type + '/' + name + '/main.js'
      }

      if(name == 'telegram') {

        entry.admin = './src/' + type + '/' + name + '/admin.js'
      }

      externals = wpexternals

      break

    case 'ui': 
      
      paths.output = destdir  + '/' + type

      entry = {
        main: './src/' + type + '/main.js'
      }
      
      mode = params[1] || 'dev'

      externals = wpexternals

      break;

    default:
      
      paths.output = destdir  + '/' + type

      entry = {
        main: './src/' + type + '/main.js'
      }
      
      mode = params[1] || 'dev'

      break
  }

  const config = {
    context: __dirname,
    stats: 'minimal',
    watch: true,
    name: 'minimal',
    entry: entry,
    output: {
      path: paths.output,
      publicPath: paths.public,
      filename: '[name].js'
    },
    mode: mode == 'prod' ? 'production' : 'development',
    devtool: mode == 'prod' ? false : 'source-map',
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          exclude: /node_modules/,
          use: [          
            { 
              loader: 'babel-loader',
              options: {
                presets: [
                  '@babel/preset-env',
                  '@babel/preset-react'
                ]
              }
            }
          ]
        },
        {
          test: /\.s[ac]ss$/i,
          exclude: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'sass-loader'
            }
          ]
        },
        {
          test: /\.css$/,
          include: /node_modules/,
          use: [
            { 
              loader: MiniCssExtractPlugin.loader
            },
            'style-loader',
            'css-loader'
          ]
        },
        // Assets
        {
          test: /\.(jpg|jpeg|png|gif|svg|woff|ttf|eot|mp3|woff|woff2|webm|mp4)$/,
          type: 'asset/resource',
          generator: {
            emit: false,
            filename: content => {

              return ('/' + content.filename).replace(pluginpublic, '')
            }
          }
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: paths.cssfilename
      })
    ],
    resolve: {
      extensions: ['.js'],
      alias: {
        assets: path.resolve(destdir + '/assets'),       
        block: path.join(__dirname, 'wp-content', 'plugins', 'poeticsoft-partner', 'block'),       
        styles: path.join(__dirname, 'src', 'styles')
      }
    }
  }
  return config
}