require('dotenv').config({path: 'variables.env'})
const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const autoprefixer = require('autoprefixer')
const { VueLoaderPlugin } = require('vue-loader');

const css = {
	loader: 'css-loader',
	options: {
		url: false,
	}
}

const postcss = {
	loader: 'postcss-loader',
	options: {
		sourceMap: true,
		plugins: function(){
			return [require('autoprefixer')]
		}
	}
}

const sass = {
	loader: 'sass-loader',
	options: {
		sourceMap: true,
		outputStyle: 'compressed',
	}
}

const global_css = {
	loader: 'sass-resources-loader',
	options: {
		resources: [
			path.resolve(__dirname, './src/sass/_variables.scss'),
			path.resolve(__dirname, './src/sass/_colors.scss'),
			path.resolve(__dirname, './src/sass/_typography.scss')
		]
	}
}

const config = {
	entry: [
		'./src/main.js'
	],
	output: {
		filename: 'build.js',
		path: path.resolve(__dirname, 'dist')
	},
	mode: process.env.NODE_ENV,
	module: {
		rules: [
			{
				test: /\.js$/,
				loader: 'babel-loader',
				options: {
					presets: ['@babel/preset-env']
				},
				exclude: /\/node_modules\//
			},
			{
				test: /\.pug$/,
				loader: 'pug-plain-loader',
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},
			{
				test: /\.scss$/,
				use: [MiniCssExtractPlugin.loader, css, postcss, sass, global_css]
			}
		]
	},
	resolve: {
		alias: {
		  '@': path.resolve('src'),
		  'vue$': 'vue/dist/vue.esm.js'
		},
		extensions: ['*', '.js', '.vue', '.json']
	  },
	plugins: [
		new MiniCssExtractPlugin({filename: 'main.css'}),
		new VueLoaderPlugin()
	],
	stats: {
		// One of the two if I remember right
		entrypoints: false,
		children: false
	}
};

module.exports = config